<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const flash = computed(() => page.props.flash ?? {})
</script>

<template>
    <div class="min-h-screen bg-slate-100">
        <header class="bg-slate-900 text-white shadow">
            <div class="mx-auto max-w-6xl px-4 py-4">
                <h1 class="text-lg font-semibold sm:text-xl">Personajes Star Wars</h1>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-6">
            <div
                v-if="flash.success"
                class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800"
            >
                {{ flash.success }}
            </div>

            <div
                v-if="flash.error"
                class="mb-4 rounded-md bg-red-100 px-4 py-3 text-sm text-red-800"
            >
                {{ flash.error }}
            </div>

            <slot />
        </main>
    </div>
</template>
