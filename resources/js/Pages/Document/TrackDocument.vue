<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useTrackDocumentStore } from '@/Store/TrackDocumentStore';
import TrackDocumentComponent from './Components/TrackDocumentComponent.vue';
const props = defineProps(['users', 'totalDocuments', 'totalSignedDocuments', 'totalPendingDocuments']);
const trackDocumentStore = useTrackDocumentStore();
trackDocumentStore.setTrackDocument(props.users);
trackDocumentStore.setSharedDocuments(props.totalDocuments);
trackDocumentStore.setSignedDocuments(props.totalSignedDocuments);
trackDocumentStore.setPendingDocuments(props.totalPendingDocuments);
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
