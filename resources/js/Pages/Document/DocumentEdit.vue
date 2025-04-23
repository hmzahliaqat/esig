<template>
    <div class="pdf-wrapper">
        <iframe ref="pdfIframe" :src="pdfViewerUrl" class="pdf-iframe"></iframe>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';

const props = defineProps(['document', 'employee_id']);
const pdfIframe = ref(null);

const pdfUrl = computed(() => `/storage/${props.document.pdf_path}`);
const pdfViewerUrl = computed(() => `/pdfjs-5.0.375-dist/web/viewer.html?file=${encodeURIComponent(pdfUrl.value)}`);

// Method to download the modified PDF






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
    position: fixed;
    /* Change to fixed to float relative to the viewport */
    bottom: 10px;
    /* Position at the bottom */
    right: 10px;
    /* Position at the right */
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1000;
    /* Ensure it stays above other elements */
}

.download-btn:hover {
    background-color: #0056b3;
}
</style>