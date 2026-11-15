<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <nav
        v-if="links.length > 3"
        class="mt-6 flex flex-wrap items-center justify-center gap-1"
        aria-label="Paginación"
    >
        <template v-for="(link, index) in links" :key="index">
            <Link
                v-if="link.url"
                :href="link.url"
                preserve-scroll
                class="rounded-md border border-slate-300 px-3 py-1.5 text-sm font-medium"
                :class="link.active ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100'"
                :aria-current="link.active ? 'page' : undefined"
            >
                <span v-html="link.label" />
            </Link>
            <span
                v-else
                class="cursor-not-allowed rounded-md border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm font-medium text-slate-400"
                v-html="link.label"
            />
        </template>
    </nav>
</template>
