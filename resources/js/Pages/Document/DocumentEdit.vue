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
          @click="selectTool(tool.type)"
        >
          {{ tool.label }}
        </button>
        <button class="save-btn" @click="savePDF">Save PDF</button>
      </div>

      <!-- PDF Canvas Container -->
      <div class="canvas-container" ref="canvasContainer" @click="handleCanvasClick">
        <canvas
          v-for="(page, index) in pages"
          :key="`page-${index}`"
          :ref="
            (el) => {
              if (el) pageRefs[index] = el;
            }
          "
          class="pdf-page"
          :width="pageWidth"
          :height="page.height * (pageWidth / page.width)"
        ></canvas>

        <!-- Form Field Placeholders -->
        <div
          v-for="field in fields"
          :key="field.id"
          :class="['field-placeholder', field.type]"
          :style="{
            left: `${field.x}px`,
            top: `${field.y}px`,
            width: `${field.width}px`,
            height: `${field.height}px`,
          }"
          @mousedown="startDragging(field, $event)"
        >
          <div class="field-label">{{ field.label }}</div>
          <button class="remove-btn" @click.stop="removeField(field.id)">×</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, reactive } from "vue";
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import axios from "axios";

const props = defineProps({
  document: Object,
  employee_id: {
    type: [Number, String],
    default: 0,
  },
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
const isDragging = ref(false);
const currentDragField = ref(null);
const dragOffset = ref({ x: 0, y: 0 });

// Tools
const tools = [
  { type: "signature", label: "Signature" },
  { type: "initials", label: "Initials" },
  { type: "date", label: "Date" },
];
const currentTool = ref("");

// Tool dimensions
const toolDimensions = {
  signature: { width: 200, height: 30 },
  initials: { width: 80, height: 40 },
  date: { width: 150, height: 40 },
};

// Load PDF.js dynamically
async function loadPdfJS() {
  if (window.pdfjsLib) return window.pdfjsLib;

  // Load PDF.js library and worker from CDN
  await loadScript("https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js");

  // Configure worker
  window.pdfjsLib.GlobalWorkerOptions.workerSrc =
    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js";

  return window.pdfjsLib;
}

// Helper function to load scripts
function loadScript(src) {
  return new Promise((resolve, reject) => {
    const script = document.createElement("script");
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
      : "https://pdf-lib.js.org/assets/with_update_sections.pdf"; // Sample PDF for testing

    const response = await fetch(pdfUrl);
    const pdfBytes = await response.arrayBuffer();
    pdfData.value = pdfBytes;

    // Load the PDF document with pdf-lib
    const pdfDocument = await PDFDocument.load(pdfBytes);
    pdfDoc.value = pdfDocument;

    // Get information about pages
    const pdfPages = pdfDocument.getPages();
    pages.value = pdfPages.map((page) => ({
      width: page.getWidth(),
      height: page.getHeight(),
    }));

    // Make sure PDF.js is loaded before rendering
    await loadPdfJS();

    // Render PDF pages to canvas
    setTimeout(renderPages, 0);
  } catch (error) {
    console.error("Error loading PDF:", error);
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

      const viewport = page.getViewport({
        scale: pageWidth.value / page.getViewport({ scale: 1.0 }).width,
      });
      const context = canvas.getContext("2d");
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      await page.render({
        canvasContext: context,
        viewport: viewport,
      }).promise;
    }
  } catch (error) {
    console.error("Error rendering PDF:", error);
  }
}

// Select a tool
function selectTool(toolType) {
  if (currentTool.value === toolType) {
    currentTool.value = "";
    return;
  }

  currentTool.value = toolType;
}

// Handle canvas click to add field
function handleCanvasClick(event) {
  // Don't add a field if we're dragging
  if (isDragging.value) return;

  const container = event.currentTarget;
  const rect = container.getBoundingClientRect();

  // Get position relative to the container
  const x = event.clientX - rect.left;
  const y = event.clientY - rect.top + container.scrollTop;

  // Check which page was clicked
  let pageIndex = -1;
  let pageY = 0;

  for (let i = 0; i < pageRefs.length; i++) {
    const canvas = pageRefs[i];
    if (!canvas) continue;

    const canvasRect = canvas.getBoundingClientRect();
    const canvasTop = canvasRect.top - rect.top + container.scrollTop;
    const canvasBottom = canvasTop + canvas.height;

    if (y >= canvasTop && y <= canvasBottom) {
      pageIndex = i;
      pageY = y;
      break;
    }
  }

  if (pageIndex >= 0) {
    addField(currentTool.value, x, pageY, pageIndex);
  }
}

// Add a field at the specified position
function addField(type, x, y, pageIndex) {
  const { width, height } = toolDimensions[type];

  // Create a new field with unique ID
  const fieldId = ++fieldIdCounter.value;

  // Generate field label based on type
  let label;
  switch (type) {
    case "signature":
      label = "Signature";
      break;
    case "initials":
      label = "Initials";
      break;
    case "date":
      label = "Date";
      break;
    default:
      label = type.charAt(0).toUpperCase() + type.slice(1);
  }

  const field = {
    id: fieldId,
    type: type,
    label: label,
    x: x - width / 2, // Center the field on the click position
    y: y - height / 2,
    width: width,
    height: height,
    pageIndex: pageIndex,
  };

  fields.value.push(field);
}

// Remove a field
function removeField(fieldId) {
  const index = fields.value.findIndex((field) => field.id === fieldId);
  if (index !== -1) {
    fields.value.splice(index, 1);
  }
}

// Start dragging a field
function startDragging(field, event) {
  event.preventDefault();

  isDragging.value = true;
  currentDragField.value = field;

  const container = canvasContainer.value;
  const rect = container.getBoundingClientRect();

  // Calculate the offset between mouse position and field position
  dragOffset.value = {
    x: event.clientX - rect.left - field.x,
    y: event.clientY - rect.top + container.scrollTop - field.y,
  };

  // Add event listeners for drag and drop
  document.addEventListener("mousemove", handleDragMove);
  document.addEventListener("mouseup", handleDragEnd);
}

// Handle drag move
function handleDragMove(event) {
  if (!isDragging.value || !currentDragField.value) return;

  const container = canvasContainer.value;
  const rect = container.getBoundingClientRect();

  // Update field position
  const field = currentDragField.value;
  field.x = event.clientX - rect.left - dragOffset.value.x;
  field.y = event.clientY - rect.top + container.scrollTop - dragOffset.value.y;

  // Find which page the field is now on
  let pageIndex = -1;
  let offsetY = 0;

  for (let i = 0; i < pageRefs.length; i++) {
    const canvas = pageRefs[i];
    if (!canvas) continue;

    const canvasRect = canvas.getBoundingClientRect();
    const canvasTop = canvasRect.top - rect.top + container.scrollTop;
    const canvasBottom = canvasTop + canvas.height;

    const fieldCenterY = field.y + field.height / 2;

    if (fieldCenterY >= canvasTop && fieldCenterY <= canvasBottom) {
      pageIndex = i;
      offsetY = fieldCenterY - canvasTop;
      break;
    }
  }

  if (pageIndex >= 0) {
    field.pageIndex = pageIndex;
  }
}

// Handle drag end
function handleDragEnd() {
  isDragging.value = false;
  currentDragField.value = null;

  // Remove event listeners
  document.removeEventListener("mousemove", handleDragMove);
  document.removeEventListener("mouseup", handleDragEnd);
}

// Save PDF with visual elements and upload to server

async function savePDF() {
  if (!pdfDoc.value) return;

  try {
    const pdfBytes = await pdfDoc.value.save();
    const newPdfDoc = await PDFDocument.load(pdfBytes);

    const helveticaFont = await newPdfDoc.embedFont(StandardFonts.Helvetica);

    for (const field of fields.value) {
      const page = newPdfDoc.getPages()[field.pageIndex];
      if (!page) continue;

      const pdfPageWidth = page.getWidth();
      const pdfPageHeight = page.getHeight();
      const scaleFactor = pdfPageWidth / pageWidth.value;

      const canvas = pageRefs[field.pageIndex];
      if (!canvas) continue;

      // Get canvas and container bounds
      const canvasRect = canvas.getBoundingClientRect();
      const containerRect = canvasContainer.value.getBoundingClientRect();

      // Compute relative position within canvas
      const relativeX =
        field.x -
        (canvasRect.left - containerRect.left + canvasContainer.value.scrollLeft);
      const relativeY =
        field.y - (canvasRect.top - containerRect.top + canvasContainer.value.scrollTop);

      // Convert to PDF coordinates
      const fieldX = relativeX * scaleFactor;
      const fieldY = pdfPageHeight - relativeY * scaleFactor;

      const fieldWidth = field.width * scaleFactor;
      const fieldHeight = field.height * scaleFactor;

      if (field.type === "signature") {
        page.drawLine({
          start: { x: fieldX, y: fieldY },
          end: { x: fieldX + fieldWidth, y: fieldY },
          thickness: 1,
          color: rgb(0, 0, 0),
        });

        page.drawText("X", {
          x: fieldX - 10,
          y: fieldY - 5,
          size: 12,
          font: helveticaFont,
          color: rgb(0, 0, 0),
        });

        page.drawText("Signature", {
          x: fieldX,
          y: fieldY - 15,
          size: 8,
          font: helveticaFont,
          color: rgb(0.3, 0.3, 0.3),
        });
      } else if (field.type === "initials") {
        page.drawRectangle({
          x: fieldX,
          y: fieldY - fieldHeight,
          width: fieldWidth,
          height: fieldHeight,
          borderColor: rgb(0, 0, 0),
          borderWidth: 1,
          opacity: 0,
        });

        page.drawText("Initials", {
          x: fieldX + 2,
          y: fieldY - fieldHeight / 2,
          size: 8,
          font: helveticaFont,
          color: rgb(0.3, 0.3, 0.3),
        });
      } else if (field.type === "date") {
        const dateLineWidth = fieldWidth / 8;

        for (let i = 0; i < 8; i++) {
          page.drawLine({
            start: { x: fieldX + i * dateLineWidth, y: fieldY },
            end: { x: fieldX + (i + 1) * dateLineWidth - 2, y: fieldY },
            thickness: 1,
            color: rgb(0, 0, 0),
          });
        }

        page.drawText("MM / DD / YYYY", {
          x: fieldX + 5,
          y: fieldY + 15,
          size: 8,
          font: helveticaFont,
          color: rgb(0.5, 0.5, 0.5),
        });

        page.drawText("Date", {
          x: fieldX,
          y: fieldY - 15,
          size: 8,
          font: helveticaFont,
          color: rgb(0.3, 0.3, 0.3),
        });
      }
    }

    const savedPdfBytes = await newPdfDoc.save();
    const blob = new Blob([savedPdfBytes], { type: "application/pdf" });

    const formData = new FormData();
    const filename = props.document?.pdf_path
      ? props.document.pdf_path.split("/").pop()
      : "document.pdf";

    formData.append("file", blob, filename);

    if (props.document?.pdf_path) {
      formData.append("filepath", props.document.pdf_path);
    }

    try {
      if (parseInt(props.employee_id) === 0) {
        await axios.post("/replace-pdf", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        sessionStorage.setItem("pdfSavedSuccess", "true");
        sessionStorage.setItem("pdfSavedMessage", "PDF successfully updated");

        window.location.href = "/documents";
      } else {
        formData.append("employee_id", props.employee_id);
        formData.append("document_id", props.document?.id);

        await axios.post("/save-shared-pdf", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        window.location.href = "/thank-you";
      }
    } catch (uploadError) {
      console.error(
        "Failed to upload the modified PDF:",
        uploadError.response?.data || uploadError.message
      );
      alert("Failed to upload the file. Please try again.");
    }
  } catch (error) {
    console.error("Error saving PDF:", error);
    alert("Error creating PDF form fields. Please try again.");
  }
}

// Lifecycle hooks
onMounted(() => {
  loadPDF();

  // Handle window resize to adjust page width
  window.addEventListener("resize", () => {
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
  background-image: linear-gradient(transparent calc(100% - 1px), #000 calc(100% - 1px));
}

.initials {
  border-color: #2ecc71;
}

.date {
  border-color: #e74c3c;
  background-image: repeating-linear-gradient(
    90deg,
    transparent,
    transparent calc(12.5% - 2px),
    #000 calc(12.5% - 2px),
    #000 12.5%
  );
  background-position: 0 calc(100% - 1px);
  background-size: 100% 1px;
  background-repeat: repeat-x;
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
</style>
