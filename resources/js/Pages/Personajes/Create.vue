<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import PersonajeForm from '../../Components/PersonajeForm.vue'
</script>

<template>
    <AppLayout>
        <h2 class="mb-4 text-xl font-semibold text-slate-800">Crear Personaje</h2>
        <PersonajeForm submit-label="Guardar" />
    </AppLayout>
</template>
