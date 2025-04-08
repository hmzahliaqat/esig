<template>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">
                    Shared Documents
                </h1>
                <div class="flex items-center space-x-4"></div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">
                                Total Documents
                            </p>
                            <p class="text-xl font-semibold text-gray-900">
                                {{ totalShared ? totalShared : 0 }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-green-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">
                                Signed Documents
                            </p>
                            <p class="text-xl font-semibold text-gray-900">
                                {{ totalSigned ? totalSigned : 0 }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-yellow-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">
                                Pending Documents
                            </p>
                            <p class="text-xl font-semibold text-gray-900">
                                {{ totalPending ? totalPending : 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <DataTable
                    v-model:expandedRowGroups="expandedRowGroups"
                    :value="customers"
                    tableStyle="min-width: 50rem"
                    expandableRowGroups
                    rowGroupMode="subheader"
                    groupRowsBy="employee.id"
                    @rowgroup-expand="onRowGroupExpand"
                    @rowgroup-collapse="onRowGroupCollapse"
                    sortMode="single"
                    sortField="=employee.name"
                    :sortOrder="1"
                >
                    <template #groupheader="slotProps">
                        <span
                            class="align-middle ml-2 font-bold leading-normal"
                            >{{ slotProps.data.employee.name }}</span
                        >
                    </template>
                    <Column field="document.title" header="Name"></Column>
                    <Column field="pdf_path" header="Pdf path"></Column>
                    <Column
                        field="document.file_type"
                        header="File type"
                    ></Column>
                    <Column field="document.page_count" header="Pages"></Column>
                    <Column
                        field="signed_at"
                        header="Signed at"
                        style="width: 20%"
                    ></Column>
                    <Column field="status" header="Status" style="width: 20%">
                        <template #body="{ data }">
                            <Badge :value="data.status" :severity="success" />
                        </template>
                    </Column>
                    <!-- New Action Column with conditional buttons -->
                    <Column header="Actions" style="width: 10%">
                        <template #body="{ data }">
                            <div class="flex gap-2">
                                <Button
                                    v-if="data.status == 'Signed'"
                                    icon="pi pi-download"
                                    class="p-button-rounded p-button-success p-button-sm"
                                    @click="downloadDocument(data)"
                                    tooltip="Download"
                                />
                                <Button
                                    v-if="data.status == 'Pending'"
                                    icon="pi pi-bell"
                                    class="p-button-rounded p-button-sm"
                                    @click="remindUser(data)"
                                    tooltip="Remind"
                                />
                            </div>
                        </template>
                    </Column>
                    <template #groupfooter="slotProps">
                        <div class="flex justify-end font-bold w-full">
                            Total Customers:
                            {{
                                calculateCustomerTotal(slotProps.data.user.name)
                            }}
                        </div>
                    </template>
                </DataTable>
                <Toast />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "primevue/usetoast";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import RadioButton from "primevue/radiobutton";
import InputNumber from "primevue/inputnumber";
import Toolbar from "primevue/toolbar";
import FileUpload from "primevue/fileupload";
import Select from "primevue/select";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import Badge from "primevue/badge";

import { useTrackDocumentStore } from "@/Store/TrackDocumentStore";
import ProgressBar from "primevue/progressbar";

const customers = ref([]);
const expandedRowGroups = ref();
const toast = useToast();
const trackDocumentStore = useTrackDocumentStore();
const totalShared = ref(null);
const totalSigned = ref(null);
const totalPending = ref(null);

const onRowGroupExpand = (event) => {
    toast.add({
        severity: "info",
        summary: "Row Group Expanded",
        detail: "Value: " + event.data,
        life: 3000,
    });
};
const onRowGroupCollapse = (event) => {
    toast.add({
        severity: "success",
        summary: "Row Group Collapsed",
        detail: "Value: " + event.data,
        life: 3000,
    });
};
const calculateCustomerTotal = (name) => {
    let total = 0;

    if (customers.value) {
        for (let customer of customers.value) {
            if (customer.representative.name === name) {
                total++;
            }
        }
    }

    return total;
};
const getSeverity = (status) => {
    switch (status) {
        case "unqualified":
            return "danger";

        case "qualified":
            return "success";

        case "new":
            return "info";

        case "negotiation":
            return "warn";

        case "renewal":
            return null;
    }
};


const downloadDocument = (data) => {
    if (!data.pdf_path) {
        toast.add({
            severity: "error",
            summary: "Download Failed",
            detail: "PDF path is missing.",
            life: 3000,
        });
        return;
    }

    // Construct the full URL to the file
    const fileUrl = `${window.location.origin}/storage/${data.pdf_path}`;
    console.log("Attempting to download from:", fileUrl);

    fetch(fileUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.href = url;
            link.download = data.document?.title || "document.pdf";
            document.body.appendChild(link);
            link.click();
            link.remove();
            // Clean up the URL object after download is initiated
            setTimeout(() => window.URL.revokeObjectURL(url), 100);
        })
        .catch(error => {
            console.error("Download failed:", error);
            toast.add({
                severity: "error",
                summary: "Download Failed",
                detail: `Unable to download the PDF. ${error.message}`,
                life: 3000,
            });
        });
};


const remindUser = (data) =>{

    try {

        axios.post('/reminder',{id:data.document.id, employee:data.employee}).then(res=>{
            console.log(res);
        });

    } catch (error) {
        console.error(error);
    }


}


onMounted(() => {
    customers.value = trackDocumentStore.trackDocument;
    totalShared.value = trackDocumentStore.totalSharedDocuments;
    totalSigned.value = trackDocumentStore.totalSignedDocuments;
    totalPending.value = trackDocumentStore.totalPendingDocuments;
});
</script>
