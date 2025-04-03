
<template>
    <div class="pdf-wrapper">
        <iframe :src="pdfViewerUrl" class="pdf-iframe"></iframe>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['document']);
const pdfUrl = computed(() => `/storage/${props.document.pdf_path}`);
const pdfViewerUrl = computed(() => `/pdfjs-5.0.375-dist/web/viewer.html?file=${encodeURIComponent(pdfUrl.value)}`);
</script>

<style scoped>
.pdf-wrapper {
    width: 100%;
    height: 100vh;
}

.pdf-iframe {
    width: 100%;
    height: 100%;
    border: none;
}
</style>
