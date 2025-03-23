import { defineStore } from 'pinia';
import { ref , watch } from 'vue';

export const useDocumentStore = defineStore('document', () => {
    const storedData = localStorage.getItem('document');

    let parsedData;
    try {
      parsedData = storedData ? JSON.parse(storedData) : [];
    } catch (error) {
      console.error("Error parsing JSON from localStorage:", error);
      parsedData = []; // Fallback to an empty array
    }

    const document = ref(parsedData);
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
