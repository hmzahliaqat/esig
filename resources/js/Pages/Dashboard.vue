<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
const props = defineProps([
  "total_documents",
  "total_employees",
  "pending_signatures",
  "completed_signatures",
  "documents_shared",
  "recent_documents",
]);
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <Welcome
            :documents="props.total_documents"
            :employees="props.total_employees"
            :pending_signatures="props?.pending_signatures"
            :completed_signatures="props?.completed_signatures"
            :documents_shared="props?.documents_shared"
            :recent_documents="props?.recent_documents"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
