<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useDocumentStore } from '@/Store/DocumentStore';
import TrackDocumentComponent from './Components/TrackDocumentComponent.vue';
const props = defineProps(['documents']);
const documentStore = useDocumentStore();
documentStore.setDocument(props.documents);
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documents
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 <TrackDocumentComponent />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
