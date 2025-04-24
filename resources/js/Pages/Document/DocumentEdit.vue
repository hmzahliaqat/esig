<template>
    <div class="pdf-container">
      <div v-if="loading" class="loading">Loading PDF...</div>

      <div v-else class="editor-container">
        <!-- Toolbar -->
        <div class="toolbar">
          <button
            v-for="tool in tools"
            :key="tool.type"
            :class="['tool-btn', { active: currentTool === tool.type }]"
            @click="selectTool(tool.type)">
            {{ tool.label }}
          </button>
          <button class="save-btn" @click="savePDF">Save PDF</button>
        </div>

        <!-- PDF Canvas Container -->
        <div class="canvas-container" ref="canvasContainer" @click="handleCanvasClick">
          <canvas
            v-for="(page, index) in pages"
            :key="`page-${index}`"
            :ref="el => { if (el) pageRefs[index] = el }"
            class="pdf-page"
            :width="pageWidth"
            :height="page.height * (pageWidth / page.width)"
          ></canvas>

          <!-- Field Placeholders -->
          <div
            v-for="field in fields"
            :key="`field-${field.id}`"
            class="field-placeholder"
            :class="field.type"
            :style="{
              left: `${field.x}px`,
              top: `${field.y}px`,
              width: `${getFieldWidth(field.type)}px`,
              height: `${getFieldHeight(field.type)}px`,
              zIndex: 10
            }">
            <div class="field-label">{{ getFieldLabel(field.type) }}</div>
            <button class="remove-btn" @click.stop="removeField(field.id)">×</button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, computed, reactive } from 'vue';
  import { PDFDocument, rgb } from 'pdf-lib';
  import axios from 'axios';

  const props = defineProps({
    document: Object,
    employee_id: {
      type: [Number, String],
      default: 0
    }
  });

  // State
  const loading = ref(true);
  const pdfDoc = ref(null);
  const pdfData = ref(null);
  const pages = ref([]);
  const pageRefs = reactive([]);
  const canvasContainer = ref(null);
  const pageWidth = ref(800); // Default width for rendering
  const fields = ref([]);
  const fieldIdCounter = ref(0);

  // Tools
  const tools = [
    { type: 'signature', label: 'Signature' },
    { type: 'initials', label: 'Initials' },
    { type: 'date', label: 'Date' }
  ];
  const currentTool = ref('signature');

  // Load PDF.js dynamically
  async function loadPdfJS() {
    if (window.pdfjsLib) return window.pdfjsLib;

    // Load PDF.js library and worker from CDN
    await loadScript('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js');

    // Configure worker
    window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    return window.pdfjsLib;
  }

  // Helper function to load scripts
  function loadScript(src) {
    return new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.src = src;
      script.onload = resolve;
      script.onerror = reject;
      document.head.appendChild(script);
    });
  }

  // Load PDF
  async function loadPDF() {
    try {
      loading.value = true;

      // In a real application, fetch the PDF from the server
      const pdfUrl = props.document?.pdf_path
        ? `/storage/${props.document.pdf_path}`
        : 'https://pdf-lib.js.org/assets/with_update_sections.pdf'; // Sample PDF for testing

      const response = await fetch(pdfUrl);
      const pdfBytes = await response.arrayBuffer();
      pdfData.value = pdfBytes;

      // Load the PDF document with pdf-lib
      const pdfDocument = await PDFDocument.load(pdfBytes);
      pdfDoc.value = pdfDocument;

      // Get information about pages
      const pdfPages = pdfDocument.getPages();
      pages.value = pdfPages.map(page => ({
        width: page.getWidth(),
        height: page.getHeight()
      }));

      // Make sure PDF.js is loaded before rendering
      await loadPdfJS();

      // Render PDF pages to canvas
      setTimeout(renderPages, 0);

    } catch (error) {
      console.error('Error loading PDF:', error);
    } finally {
      loading.value = false;
    }
  }

  // Render PDF pages
  async function renderPages() {
    if (!pdfData.value) return;

    try {
      const pdfjsLib = await loadPdfJS();

      // Load the PDF with PDF.js
      const loadingTask = pdfjsLib.getDocument({ data: pdfData.value });
      const pdf = await loadingTask.promise;

      for (let i = 0; i < pdf.numPages; i++) {
        const page = await pdf.getPage(i + 1);
        const canvas = pageRefs[i];
        if (!canvas) continue;

        const viewport = page.getViewport({ scale: pageWidth.value / page.getViewport({ scale: 1.0 }).width });
        const context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        await page.render({
          canvasContext: context,
          viewport: viewport
        }).promise;
      }
    } catch (error) {
      console.error('Error rendering PDF:', error);
    }
  }

  // Tool selection
  function selectTool(toolType) {
    currentTool.value = toolType;
  }

function getStaticLabel(type) {
  switch (type) {
    case 'signature': return 'Sign Here';
    case 'initials': return 'Initial Here';
    case 'date': return 'Enter Date';
    default: return 'Field';
  }
}


  // Handle canvas click to add field
  function handleCanvasClick(event) {
    if (!currentTool.value) return;

    // Calculate position relative to the canvas container
    const rect = canvasContainer.value.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top + canvasContainer.value.scrollTop;

    // Determine which page was clicked
    const pageIndex = getPageIndexFromY(y);

    // Calculate position relative to the page
    let pageTop = 0;
    for (let i = 0; i < pageIndex; i++) {
      const canvas = pageRefs[i];
      if (canvas) pageTop += canvas.height + 20; // Add page height + margin
    }

    const pageY = y - pageTop;

    // Add field
    fields.value.push({
      id: ++fieldIdCounter.value,
      type: currentTool.value,
      x,
      y,
      pageY,
      pageIndex
    });
  }

  // Get page index from Y position
  function getPageIndexFromY(y) {
    let accumulatedHeight = 0;
    for (let i = 0; i < pageRefs.length; i++) {
      const canvas = pageRefs[i];
      if (!canvas) continue;

      accumulatedHeight += canvas.height + 20; // Add page height + margin
      if (y < accumulatedHeight) {
        return i;
      }
    }
    return Math.max(0, pageRefs.length - 1);
  }

  // Remove field
  function removeField(id) {
    fields.value = fields.value.filter(field => field.id !== id);
  }

  // Get field dimensions based on type
  function getFieldWidth(type) {
    switch (type) {
      case 'signature': return 200;
      case 'initials': return 100;
      case 'date': return 150;
      default: return 150;
    }
  }

  function getFieldHeight(type) {
    switch (type) {
      case 'signature': return 80;
      case 'initials': return 60;
      case 'date': return 40;
      default: return 50;
    }
  }

  function getFieldLabel(type) {
    switch (type) {
      case 'signature': return 'Signature';
      case 'initials': return 'Initials';
      case 'date': return 'Date';
      default: return 'Field';
    }
  }

  // Save PDF with form fields and upload to server
  async function savePDF() {
    if (!pdfDoc.value) return;

    try {
      // Clone the document
      const pdfBytes = await pdfDoc.value.save();
      const newPdfDoc = await PDFDocument.load(pdfBytes);

      // Add form fields to the PDF
      const form = newPdfDoc.getForm();

      fields.value.forEach(field => {
        const pdfPage = newPdfDoc.getPages()[field.pageIndex];
        if (!pdfPage) return;

        // Convert canvas coordinates to PDF coordinates
        const pageHeight = pdfPage.getHeight();
        const pageWidth = pdfPage.getWidth();
        const canvas = pageRefs[field.pageIndex];
        if (!canvas) return;

        const scaleX = pageWidth / canvas.width;
        const scaleY = pageHeight / canvas.height;

        // Calculate position on the page
        const pdfX = (field.x - canvas.offsetLeft) * scaleX;

        // In PDF coordinates, (0,0) is at the bottom-left, not top-left
        const pdfY = pageHeight - (field.pageY * scaleY) - (getFieldHeight(field.type) * scaleY);

        const width = getFieldWidth(field.type) * scaleX;
        const height = getFieldHeight(field.type) * scaleY;

        switch (field.type) {
          case 'signature':
            const signatureField = form.createTextField(`signature-${field.id}`);
            signatureField.setText('');
            signatureField.enableReadOnly(); // Prevent user editing

            signatureField.addToPage(pdfPage, {
              x: pdfX,
              y: pdfY,
              width,
              height,
              borderWidth: 1,
              borderColor: rgb(0.75, 0.75, 0.75)
            });
            break;
          case 'initials':
            const initialsField = form.createTextField(`initials-${field.id}`);
            initialsField.setText('signature');
            signatureField.enableReadOnly(); // Prevent user editing
            initialsField.addToPage(pdfPage, {
              x: pdfX,
              y: pdfY,
              width,
              height,
              borderWidth: 1,
              borderColor: rgb(0.75, 0.75, 0.75)
            });
            break;
          case 'date':
            const dateField = form.createTextField(`date-${field.id}`);
            dateField.setText('');
            dateField.addToPage(pdfPage, {
              x: pdfX,
              y: pdfY,
              width,
              height,
              borderWidth: 1,
              borderColor: rgb(0.75, 0.75, 0.75)
            });
            break;
        }
      });

      // Save the PDF with form fields
      const savedPdfBytes = await newPdfDoc.save();

      // Create a blob from the PDF data
      const blob = new Blob([savedPdfBytes], { type: 'application/pdf' });

      // Prepare form data for upload
      const formData = new FormData();

      // Get filename from path or use default
      const filename = props.document?.pdf_path
        ? props.document.pdf_path.split('/').pop()
        : 'document.pdf';

      formData.append('file', blob, filename);

      if (props.document?.pdf_path) {
        formData.append('filepath', props.document.pdf_path);
      }

      try {
        // Handle different upload paths based on employee_id
        if (parseInt(props.employee_id) === 0) {
          // Upload for admin/owner
          const response = await axios.post('/replace-pdf', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });

          // Set success message in session storage
          sessionStorage.setItem('pdfSavedSuccess', 'true');
          sessionStorage.setItem('pdfSavedMessage', 'PDF successfully updated');

          // Redirect to documents page
          window.location.href = '/documents';
        } else {
          // Upload for shared document
          formData.append('employee_id', props.employee_id);
          formData.append('document_id', props.document?.id);

          const response = await axios.post('/save-shared-pdf', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });

          // Redirect to thank you page
          window.location.href = '/thank-you';
        }
      } catch (error) {
        console.error('Failed to upload the modified PDF:', error.response?.data || error.message);
        alert('Failed to upload the file. Please try again.');
      }

    } catch (error) {
      console.error('Error saving PDF:', error);
      alert('Error creating PDF form fields. Please try again.');
    }
  }

  // Lifecycle hooks
  onMounted(() => {
    loadPDF();

    // Handle window resize to adjust page width
    window.addEventListener('resize', () => {
      if (canvasContainer.value) {
        pageWidth.value = canvasContainer.value.clientWidth - 40; // Account for padding
        renderPages();
      }
    });
  });
  </script>

  <style scoped>
  .pdf-container {
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: #f0f0f0;
  }

  .loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    font-size: 18px;
    color: #555;
  }

  .editor-container {
    display: flex;
    flex-direction: column;
    flex: 1;
    overflow: hidden;
  }

  .toolbar {
    display: flex;
    padding: 10px;
    background-color: #fff;
    border-bottom: 1px solid #ddd;
    gap: 10px;
  }

  .tool-btn {
    padding: 8px 12px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
  }

  .tool-btn.active {
    background-color: #e0e0ff;
    border-color: #9090ff;
  }

  .save-btn {
    margin-left: auto;
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .save-btn:hover {
    background-color: #0056b3;
  }

  .canvas-container {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    position: relative;
  }

  .pdf-page {
    display: block;
    margin: 0 auto 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    background-color: white;
  }

  .field-placeholder {
    position: absolute;
    border: 2px dashed #666;
    background-color: rgba(255, 255, 255, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: move;
  }

  .signature {
    border-color: #3498db;
  }

  .initials {
    border-color: #2ecc71;
  }

  .date {
    border-color: #e74c3c;
  }

  .field-label {
    font-size: 12px;
    color: #555;
    pointer-events: none;
  }

  .remove-btn {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 20px;
    height: 20px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    line-height: 1;
  }
  .field-static-label {
  position: absolute;
  top: -20px; /* Adjust as needed */
  left: 0;
  font-size: 12px;
  color: #333;
  background-color: #fff;
  padding: 2px 4px;
  border: 1px solid #ddd;
  border-radius: 4px;
  pointer-events: none;
  white-space: nowrap;
}
  </style>