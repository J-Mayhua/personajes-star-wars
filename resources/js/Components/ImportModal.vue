<script setup>
import { useForm } from '@inertiajs/vue3'

defineProps({
    show: {
        type: Boolean,
        required: true,
    },
})

const emit = defineEmits(['close'])

const form = useForm({
    swapi_id: '',
})

const cerrar = () => {
    form.reset()
    form.clearErrors()
    emit('close')
}

const enviar = () => {
    form.post('/personajes/importar', {
        preserveScroll: true,
        onSuccess: () => cerrar(),
    })
}
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
        @click.self="cerrar"
    >
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Importar desde SWAPI</h2>

            <form @submit.prevent="enviar">
                <div>
                    <label for="swapi_id" class="mb-1 block text-sm font-medium text-slate-700">ID de SWAPI</label>
                    <input
                        id="swapi_id"
                        v-model="form.swapi_id"
                        type="number"
                        min="1"
                        max="83"
                        required
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                    />
                    <p v-if="form.errors.swapi_id" class="mt-1 text-sm text-red-600">{{ form.errors.swapi_id }}</p>
                </div>

                <p v-if="form.processing" class="mt-3 text-sm text-slate-600">Consultando SWAPI...</p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center gap-2 rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span
                            v-if="form.processing"
                            class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"
                        />
                        Importar
                    </button>

                    <button
                        type="button"
                        :disabled="form.processing"
                        class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-60"
                        @click="cerrar"
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
