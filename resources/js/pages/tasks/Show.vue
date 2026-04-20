<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

defineProps<{
    task: {
        id: number;
        title: string;
        description: string | null;
        status: string;
        priority: string;
        due_date: string | null;
        project: {
            id: number;
            name: string;
        } | null;
    };
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboard() },
            { title: 'Task', href: '/tasks' },
        ],
    },
});
</script>

<template>
    <Head :title="task.title" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ task.title }}</h1>

            <div class="flex gap-2">
                <Link :href="`/tasks/${task.id}/edit`">
                    <Button label="Modifica" icon="pi pi-pencil" />
                </Link>
                <Link href="/tasks">
                    <Button label="Torna alla lista" severity="secondary" outlined />
                </Link>
            </div>
        </div>

        <Card>
            <template #content>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div><strong>Progetto:</strong> {{ task.project?.name || '-' }}</div>
                    <div><strong>Scadenza:</strong> {{ task.due_date || '-' }}</div>
                    <div><strong>Stato:</strong> <Tag :value="task.status" severity="info" /></div>
                    <div><strong>Priorità:</strong> <Tag :value="task.priority" severity="warn" /></div>
                    <div class="md:col-span-2"><strong>Descrizione:</strong> {{ task.description || '-' }}</div>
                </div>
            </template>
        </Card>
    </div>
</template>