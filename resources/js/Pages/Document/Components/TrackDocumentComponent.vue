<template>
  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Shared Documents</h1>
        <div class="flex items-center space-x-4">

        </div>
      </div>

      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="bg-blue-100 p-3 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Documents</p>
              <p class="text-xl font-semibold text-gray-900">{{ totalDocuments }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="bg-green-100 p-3 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Signed Documents</p>
              <p class="text-xl font-semibold text-gray-900">{{ signedDocuments }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="bg-yellow-100 p-3 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Pending Documents</p>
              <p class="text-xl font-semibold text-gray-900">{{ pendingDocuments }}</p>
            </div>
          </div>
        </div>
      </div>





      <div class="card">
        <DataTable v-model:expandedRowGroups="expandedRowGroups" :value="customers" tableStyle="min-width: 50rem"
                expandableRowGroups rowGroupMode="subheader" groupRowsBy="representative.name" @rowgroup-expand="onRowGroupExpand" @rowgroup-collapse="onRowGroupCollapse"
                sortMode="single" sortField="representative.name" :sortOrder="1">
            <template #groupheader="slotProps">
                <!-- <img :alt="slotProps.data.representative.name" :src="`https://primefaces.org/cdn/primevue/images/avatar/${slotProps.data.representative.image}`" width="32" style="vertical-align: middle; display: inline-block" class="ml-2" /> -->
                <span class="align-middle ml-2 font-bold leading-normal">{{ slotProps.data.representative.name }}</span>
            </template>
            <Column field="representative.name" header="Representative"></Column>
            <Column field="name" header="Name" style="width: 20%"></Column>
            <Column field="country" header="Country" style="width: 20%">
                <template #body="slotProps">
                    <div class="flex items-center gap-2">
                        <img alt="flag" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`flag flag-${slotProps.data.country.code}`" style="width: 24px" />
                        <span>{{ slotProps.data.country.name }}</span>
                    </div>
                </template>
            </Column>
            <Column field="company" header="Company" style="width: 20%"></Column>
            <Column field="status" header="Status" style="width: 20%">
                <template #body="slotProps">
                    <Tag :value="slotProps.data.status" :severity="getSeverity(slotProps.data.status)" />
                </template>
            </Column>
            <Column field="date" header="Date" style="width: 20%"></Column>
            <template #groupfooter="slotProps">
                <div class="flex justify-end font-bold w-full">Total Customers: {{ calculateCustomerTotal(slotProps.data.representative.name) }}</div>
            </template>
        </DataTable>
        <Toast />
    </div>








    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import RadioButton from 'primevue/radiobutton';
import InputNumber from 'primevue/inputnumber';
import Toolbar from 'primevue/toolbar';
import FileUpload from 'primevue/fileupload';
import Select from 'primevue/select';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import { useDocumentStore } from '@/Store/DocumentStore';
import ProgressBar from 'primevue/progressbar';
onMounted(() => {
    // Use static data for now
    customers.value = [
        {
            representative: { name: 'John Doe', image: 'john.jpg' },
            name: 'Customer A',
            country: { code: 'US', name: 'United States' },
            company: 'Company A',
            status: 'qualified',
            date: '2025-01-01'
        },
        {
            representative: { name: 'John Doe', image: 'john.jpg' },
            name: 'Customer B',
            country: { code: 'GB', name: 'United Kingdom' },
            company: 'Company B',
            status: 'new',
            date: '2025-01-02'
        },
        {
            representative: { name: 'Jane Smith', image: 'jane.jpg' },
            name: 'Customer C',
            country: { code: 'CA', name: 'Canada' },
            company: 'Company C',
            status: 'negotiation',
            date: '2025-01-03'
        },
        {
            representative: { name: 'Jane Smith', image: 'jane.jpg' },
            name: 'Customer D',
            country: { code: 'FR', name: 'France' },
            company: 'Company D',
            status: 'unqualified',
            date: '2025-01-04'
        }
    ];
});

const customers = ref([]);
const expandedRowGroups = ref();
const toast = useToast();
const onRowGroupExpand = (event) => {
    toast.add({ severity: 'info', summary: 'Row Group Expanded', detail: 'Value: ' + event.data, life: 3000 });
};
const onRowGroupCollapse = (event) => {
    toast.add({ severity: 'success', summary: 'Row Group Collapsed', detail: 'Value: ' + event.data, life: 3000 });
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
        case 'unqualified':
            return 'danger';

        case 'qualified':
            return 'success';

        case 'new':
            return 'info';

        case 'negotiation':
            return 'warn';

        case 'renewal':
            return null;
    }
};
</script>

