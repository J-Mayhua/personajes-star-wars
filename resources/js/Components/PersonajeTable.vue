<script setup>
import { Link, router } from '@inertiajs/vue3'

defineProps({
    personajes: {
        type: Array,
        required: true,
    },
})

const origenLabel = (personaje) => (personaje.origen_swapi ? 'SWAPI' : 'Manual')

const eliminar = (personaje) => {
    if (confirm('¿Eliminar este personaje?')) {
        router.delete(`/personajes/${personaje.id}`)
    }
}
</script>

<template>
    <div
        v-if="personajes.length === 0"
        class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 shadow"
    >
        No hay personajes registrados.
    </div>

    <template v-else>
        <div class="hidden overflow-x-auto rounded-lg bg-white shadow md:block">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Nombre</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Altura</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Masa</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Género</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Origen</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr v-for="personaje in personajes" :key="personaje.id" class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ personaje.nombre }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ personaje.altura ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ personaje.masa ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ personaje.genero }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ origenLabel(personaje) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <Link
                                    :href="`/personajes/${personaje.id}/editar`"
                                    class="rounded-md border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100"
                                >
                                    Editar
                                </Link>
                                <button
                                    type="button"
                                    class="rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700"
                                    @click="eliminar(personaje)"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="space-y-4 md:hidden">
            <article
                v-for="personaje in personajes"
                :key="personaje.id"
                class="rounded-lg bg-white p-4 shadow"
            >
                <div class="flex items-start justify-between gap-4">
                    <h3 class="text-base font-semibold text-slate-900">{{ personaje.nombre }}</h3>
                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                        {{ origenLabel(personaje) }}
                    </span>
                </div>

                <dl class="mt-3 grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <dt class="text-slate-500">Altura</dt>
                        <dd class="text-slate-800">{{ personaje.altura ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Masa</dt>
                        <dd class="text-slate-800">{{ personaje.masa ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Género</dt>
                        <dd class="text-slate-800">{{ personaje.genero }}</dd>
                    </div>
                </dl>

                <div class="mt-4 flex gap-2">
                    <Link
                        :href="`/personajes/${personaje.id}/editar`"
                        class="flex-1 rounded-md border border-slate-300 px-3 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-100"
                    >
                        Editar
                    </Link>
                    <button
                        type="button"
                        class="flex-1 rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700"
                        @click="eliminar(personaje)"
                    >
                        Eliminar
                    </button>
                </div>
            </article>
        </div>
    </template>
</template>
