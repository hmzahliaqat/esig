import { defineStore } from 'pinia';
import { ref , watch } from 'vue';

export const useDocumentStore = defineStore('document', () => {
    const document = ref(JSON.parse(localStorage.getItem('document')) || []);

    const setDocument = (data) => {
        document.value = data;
    };

    const addDocument= (data) => {
        document.value.push(data);
    };

    watch(document, (newVal) => {
        localStorage.setItem('document', JSON.stringify(newVal));
    }, { deep: true });

    return { document, setDocument, addDocument };
});
