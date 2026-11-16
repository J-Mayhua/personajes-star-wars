<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    personaje: {
        type: Object,
        default: null,
    },
    submitLabel: {
        type: String,
        required: true,
    },
})

const form = useForm({
    nombre: props.personaje?.nombre ?? '',
    altura: props.personaje?.altura ?? '',
    masa: props.personaje?.masa ?? '',
    color_cabello: props.personaje?.color_cabello ?? '',
    color_ojos: props.personaje?.color_ojos ?? '',
    genero: props.personaje?.genero ?? '',
    planeta_origen: props.personaje?.planeta_origen ?? '',
})

const enviar = () => {
    if (props.personaje) {
        form.put(`/personajes/${props.personaje.id}`)
        return
    }

    form.post('/personajes')
}
</script>

<template>
    <form class="rounded-lg bg-white p-6 shadow" @submit.prevent="enviar">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label for="nombre" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                <input
                    id="nombre"
                    v-model="form.nombre"
                    type="text"
                    required
                    minlength="3"
                    maxlength="100"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                />
                <p v-if="form.errors.nombre" class="mt-1 text-sm text-red-600">{{ form.errors.nombre }}</p>
            </div>

            <div>
                <label for="genero" class="mb-1 block text-sm font-medium text-slate-700">Género</label>
                <select
                    id="genero"
                    v-model="form.genero"
                    required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                >
                    <option value="" disabled>Selecciona un género</option>
                    <option value="masculino">masculino</option>
                    <option value="femenino">femenino</option>
                    <option value="n/a">n/a</option>
                </select>
                <p v-if="form.errors.genero" class="mt-1 text-sm text-red-600">{{ form.errors.genero }}</p>
            </div>

            <div>
                <label for="altura" class="mb-1 block text-sm font-medium text-slate-700">Altura (cm)</label>
                <input
                    id="altura"
                    v-model="form.altura"
                    type="number"
                    min="1"
                    max="300"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                />
                <p v-if="form.errors.altura" class="mt-1 text-sm text-red-600">{{ form.errors.altura }}</p>
            </div>

            <div>
                <label for="masa" class="mb-1 block text-sm font-medium text-slate-700">Masa (kg)</label>
                <input
                    id="masa"
                    v-model="form.masa"
                    type="number"
                    min="1"
                    max="500"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                />
                <p v-if="form.errors.masa" class="mt-1 text-sm text-red-600">{{ form.errors.masa }}</p>
            </div>

            <div>
                <label for="color_cabello" class="mb-1 block text-sm font-medium text-slate-700">Color de cabello</label>
                <input
                    id="color_cabello"
                    v-model="form.color_cabello"
                    type="text"
                    maxlength="100"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                />
                <p v-if="form.errors.color_cabello" class="mt-1 text-sm text-red-600">{{ form.errors.color_cabello }}</p>
            </div>

            <div>
                <label for="color_ojos" class="mb-1 block text-sm font-medium text-slate-700">Color de ojos</label>
                <input
                    id="color_ojos"
                    v-model="form.color_ojos"
                    type="text"
                    maxlength="100"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                />
                <p v-if="form.errors.color_ojos" class="mt-1 text-sm text-red-600">{{ form.errors.color_ojos }}</p>
            </div>

            <div class="md:col-span-2">
                <label for="planeta_origen" class="mb-1 block text-sm font-medium text-slate-700">Planeta de origen</label>
                <input
                    id="planeta_origen"
                    v-model="form.planeta_origen"
                    type="text"
                    maxlength="100"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"
                />
                <p v-if="form.errors.planeta_origen" class="mt-1 text-sm text-red-600">{{ form.errors.planeta_origen }}</p>
            </div>

            <div class="flex flex-wrap gap-2 md:col-span-2">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span
                        v-if="form.processing"
                        class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"
                    />
                    {{ submitLabel }}
                </button>

                <Link
                    href="/personajes"
                    class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                >
                    Cancelar
                </Link>
            </div>
        </div>
    </form>
</template>
