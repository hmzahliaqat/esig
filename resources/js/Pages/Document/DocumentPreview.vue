<template>
    <div class="pdf-wrapper">
        <iframe ref="pdfIframe" :src="pdfViewerUrl" class="pdf-iframe"></iframe>
        <button class="download-btn" @click="downloadModifiedPdf">Download Modified PDF</button>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';

const props = defineProps(['document', 'employee_id']);
const pdfIframe = ref(null);

const pdfUrl = computed(() => `/storage/${props.document.pdf_path}`);
const pdfViewerUrl = computed(() => `/pdfjs-5.0.375-dist/web/viewer.html?file=${encodeURIComponent(pdfUrl.value)}`);

// Method to download the modified PDF
const downloadModifiedPdf = async () => {
    const iframeWindow = pdfIframe.value?.contentWindow;
    if (iframeWindow && iframeWindow.PDFViewerApplication) {
        try {
            const modifiedPdfData = await iframeWindow.PDFViewerApplication.pdfDocument.saveDocument();
            const blob = new Blob([modifiedPdfData], { type: 'application/pdf' });

            const formData = new FormData();
            formData.append('file', blob, props.document.pdf_path.split('/').pop()); // Add the file
            formData.append('filepath', props.document.pdf_path); // Add the filepath

            if(props.employee_id == 0){
            const response = await axios.post('/replace-pdf', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            console.log(response.data.message); // Log success message
            alert('File uploaded successfully!');
        }else{
            formData.append('employee_id', props?.employee_id);
            formData.append('document_id', props?.document?.id);
            const response = await axios.post('/save-shared-pdf', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            console.log(response.data.message); // Log success message
            alert('File uploaded successfully!');
        }
        } catch (error) {
            console.error('Failed to upload the modified PDF:', error.response?.data || error.message);
            alert('Failed to upload the file. Please try again.');
        }
    } else {
        console.error('PDF.js viewer is not loaded or accessible.');
        alert('PDF.js viewer is not loaded or accessible.');
    }
};





</script>

<style scoped>
.pdf-wrapper {
    width: 100%;
    height: 100vh;
    position: relative;
}

.pdf-iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.download-btn {
    position: fixed; /* Change to fixed to float relative to the viewport */
    bottom: 10px; /* Position at the bottom */
    right: 10px; /* Position at the right */
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1000; /* Ensure it stays above other elements */
}

.download-btn:hover {
    background-color: #0056b3;
}
</style>