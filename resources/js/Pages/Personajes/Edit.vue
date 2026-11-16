<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import PersonajeForm from '../../Components/PersonajeForm.vue'

defineProps({
    personaje: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <AppLayout>
        <h2 class="mb-4 text-xl font-semibold text-slate-800">Editar Personaje</h2>
        <PersonajeForm :personaje="personaje" submit-label="Actualizar" />
    </AppLayout>
</template>
