<template>
  <Drawer v-model:visible="visibleRight" header="Share Document" position="right">
    <!-- Share All Button -->
    <div class="mb-6 px-4">
      <Button
        icon="pi pi-share-alt"
        label="Share All"
        class="p-button-outlined w-full"
        @click="shareAll"
      />
    </div>

    <!-- User List -->
    <div class="px-4">
      <div
        v-for="employee in employees"
        :key="employee.id"
        class="flex items-center justify-between mb-4 py-2 border-b border-gray-200"
      >
        <span class="text-gray-800 font-medium">{{ employee.name }}</span>
        <Button
          icon="pi pi-share-alt"
          class="p-button-rounded p-button-text"
          @click="shareUser(employee)"
        />
      </div>
    </div>
  </Drawer>
</template>

<script setup>
import { ref, watch } from "vue";
import Drawer from "primevue/drawer";
import Button from "primevue/button";
import { useEmployeeStore } from "@/Store/EmployeeStore";
import { useDocumentStore } from "@/Store/DocumentStore";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
const props = defineProps({
  visible: {
    type: Boolean,
    default: false,
  },
  id: {
    type: Number,
    default: null,
  },
});
const employeeStore = useEmployeeStore();
const documentStore = useDocumentStore();
const visibleRight = ref(props.visible);
const $toast = useToast();

// Watch for changes in the visible prop to update the drawer visibility
watch(
  () => props.visible,
  (newVal) => {
    visibleRight.value = newVal;
  }
);

const employees = employeeStore.employee;

// Function to share the document with a specific user
const shareUser = (user) => {
  const documet = documentStore.document.find((doc) => doc.id == props.id);
  axios
    .post("/share/document", {
      id: props.id,
      employee: user,
      access_hash: documet?.access_hash,
      _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    })
    .then((res) => {
      visibleRight.value = false;

      $toast.success(res?.data?.message, {
        position: "top-right",
      });
    })
    .catch((error) => {
      visibleRight.value = false;

      $toast.error(error?.response?.data?.message, {
        position: "top-right",
      });
    });
};

// Function to share the document with all users
const shareAll = () => {
  console.log("Sharing document with all users");
};
</script>
