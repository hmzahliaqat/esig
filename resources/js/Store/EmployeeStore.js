import { defineStore } from 'pinia';
import { ref , watch } from 'vue';

export const useEmployeeStore = defineStore('employee', () => {
    const employee = ref(JSON.parse(localStorage.getItem('employee')) || []);

    const setEmployee = (data) => {
        employee.value = data;
    };

    const addEmployee= (data) => {
        employee.value.push(data);
    };

    const importEmployees = (newEmployees) => {
        newEmployees.forEach(emp => employee.value.push(emp));
    };

    watch(employee, (newVal) => {
        console.log("Updated Employees:", newVal); // Debugging log

        localStorage.setItem('employee', JSON.stringify(newVal));
    }, { deep: true });

    return { employee, setEmployee, addEmployee, importEmployees };
});
