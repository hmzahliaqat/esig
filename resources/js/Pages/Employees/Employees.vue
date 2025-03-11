<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from './Components/Table.vue';
import { useEmployeeStore } from '@/Store/EmployeeStore';
const props = defineProps(['employees']);
const employeeStore = useEmployeeStore();

employeeStore.setEmployee(props.employees);

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Employees
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Table />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
