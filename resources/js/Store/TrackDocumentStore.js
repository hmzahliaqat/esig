import { defineStore } from "pinia";
import { ref, watch } from "vue";

export const useTrackDocumentStore = defineStore("trackDocument", () => {
    const trackDocument = ref(
        JSON.parse(localStorage.getItem("trackDocument")) || []
    );
    const totalSharedDocuments = ref(
        JSON.parse(localStorage.getItem("totalSharedDocuments")) || []
    );
    const totalSignedDocuments = ref(
        JSON.parse(localStorage.getItem("totalSignedDocuments")) || []
    );
    const totalPendingDocuments = ref(
        JSON.parse(localStorage.getItem("totalPendingDocuments")) || []
    );

    const setTrackDocument = (data) => {
        trackDocument.value = data;
    };

    const setSharedDocuments = (data) => {
        totalSharedDocuments.value = data;
    };

    const setSignedDocuments = (data) => {
        totalSignedDocuments.value = data;
    };

    const setPendingDocuments = (data) => {
        totalPendingDocuments.value = data;
    };

    watch(
        trackDocument,
        (newVal) => {
            localStorage.setItem("trackDocument", JSON.stringify(newVal));
        },
        { deep: true }
    );

    watch(
        totalSharedDocuments,
        (newVal) => {
            localStorage.setItem(
                "totalSharedDocuments",
                JSON.stringify(newVal)
            );
        },
        { deep: true }
    );

    watch(
        totalSignedDocuments,
        (newVal) => {
            localStorage.setItem(
                "totalSignedDocuments",
                JSON.stringify(newVal)
            );
        },
        { deep: true }
    );

    watch(
        totalPendingDocuments,
        (newVal) => {
            localStorage.setItem(
                "totalPendingDocuments",
                JSON.stringify(newVal)
            );
        },
        { deep: true }
    );

    return {
        trackDocument,
        totalSharedDocuments,
        totalSignedDocuments,
        totalPendingDocuments,
        setTrackDocument,
        setSharedDocuments,
        setSignedDocuments,
        setPendingDocuments,
    };
});
