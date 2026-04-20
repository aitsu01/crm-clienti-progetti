<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

type ClientItem = {
    id: number;
    full_name: string;
};

type TaskItem = {
    id: number;
    title: string;
    status: string;
    priority: string;
    due_date: string | null;
};

defineProps<{
    project: {
        id: number;
        name: string;
        description: string | null;
        status: string;
        start_date: string | null;
        end_date: string | null;
        clients: ClientItem[];
        tasks: TaskItem[];
    };
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboard() },
            { title: 'Progetti', href: '/projects' },
        ],
    },
});
</script>

<template>
    <Head :title="project.name" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ project.name }}</h1>

            <div class="flex gap-2">
                <Link :href="`/projects/${project.id}/edit`">
                    <Button label="Modifica" icon="pi pi-pencil" />
                </Link>
                <Link href="/projects">
                    <Button label="Torna alla lista" severity="secondary" outlined />
                </Link>
            </div>
        </div>

        <Card>
            <template #content>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div><strong>Stato:</strong> {{ project.status }}</div>
                    <div><strong>Data inizio:</strong> {{ project.start_date || '-' }}</div>
                    <div><strong>Data fine:</strong> {{ project.end_date || '-' }}</div>
                    <div class="md:col-span-2"><strong>Descrizione:</strong> {{ project.description || '-' }}</div>
                </div>
            </template>
        </Card>

        <Card>
            <template #title>Clienti associati</template>
            <template #content>
                <div v-if="project.clients.length" class="flex flex-wrap gap-2">
                    <Tag
                        v-for="client in project.clients"
                        :key="client.id"
                        :value="client.full_name"
                        severity="secondary"
                    />
                </div>
                <p v-else>Nessun cliente associato.</p>
            </template>
        </Card>

        <Card>
            <template #title>Task progetto</template>
            <template #content>
                <div v-if="project.tasks.length" class="space-y-3">
                    <div
                        v-for="task in project.tasks"
                        :key="task.id"
                        class="rounded-lg border p-3"
                    >
                        <div class="font-medium">{{ task.title }}</div>
                        <div class="mt-1 text-sm text-gray-500">
                            Stato: {{ task.status }} · Priorità: {{ task.priority }} · Scadenza: {{ task.due_date || '-' }}
                        </div>
                    </div>
                </div>
                <p v-else>Nessuna task associata.</p>
            </template>
        </Card>
    </div>
</template>