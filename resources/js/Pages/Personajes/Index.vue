<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '../../Layouts/AppLayout.vue'
import PersonajeTable from '../../Components/PersonajeTable.vue'
import Pagination from '../../Components/Pagination.vue'
import ImportModal from '../../Components/ImportModal.vue'

const showImportModal = ref(false)

defineProps({
    personajes: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <AppLayout>
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-slate-800">Personajes</h2>
            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                    @click="showImportModal = true"
                >
                    Importar desde SWAPI
                </button>
                <Link
                    href="/personajes/crear"
                    class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700"
                >
                    Crear Nuevo
                </Link>
            </div>
        </div>

        <PersonajeTable :personajes="personajes.data" />
        <Pagination :links="personajes.links" />

        <ImportModal :show="showImportModal" @close="showImportModal = false" />
    </AppLayout>
</template>
