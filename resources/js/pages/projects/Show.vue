<script setup lang="ts">

import { Head, Link, router } from '@inertiajs/vue3';


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
    description?: string | null;
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

const statusSeverity = (status: string) => {
    switch (status) {
        case 'completata':
        case 'completato':
            return 'success';
        case 'in_corso':
            return 'info';
        case 'in_revisione':
        case 'sospeso':
            return 'warn';
        case 'bloccata':
            return 'danger';
        default:
            return 'secondary';
    }
};

const prioritySeverity = (priority: string) => {
    switch (priority) {
        case 'alta':
            return 'danger';
        case 'media':
            return 'warn';
        default:
            return 'secondary';
    }
};

const destroyTask = (id: number) => {
    if (confirm('Sei sicuro di voler eliminare questa task?')) {
        router.delete(`/tasks/${id}`);
    }
};



</script>

<template>
    <Head :title="project.name" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ project.name }}</h1>

            <div class="flex gap-2">
                <Link :href="`/tasks/create?project_id=${project.id}`">
                    <Button label="Inserisci nuova task" icon="pi pi-plus" severity="success" />
                </Link>

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
                    <div class="md:col-span-2">
                        <strong>Descrizione:</strong> {{ project.description || '-' }}
                    </div>
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
                <div v-if="project.tasks.length" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <Card
                        v-for="task in project.tasks"
                        :key="task.id"
                        class="h-full"
                    >
                        <template #title>
                            <div class="text-lg font-semibold">
                                {{ task.title }}
                            </div>
                        </template>

                        <template #content>
                            <div class="space-y-4">
                                <p class="min-h-[72px] text-sm text-muted-foreground">
                                    {{ task.description || 'Nessuna descrizione disponibile.' }}
                                </p>

                                <div class="flex flex-wrap gap-2">
                                    <Tag :value="task.status" :severity="statusSeverity(task.status)" />
                                    <Tag :value="task.priority" :severity="prioritySeverity(task.priority)" />
                                    <Tag
                                        v-if="task.due_date"
                                        :value="`Scadenza: ${task.due_date}`"
                                        severity="contrast"
                                    />
                                </div>

                                <div class="flex flex-wrap gap-2 pt-2">
    <Link :href="`/tasks/${task.id}`">
        <Button label="Vedi" icon="pi pi-eye" severity="secondary" size="small" />
    </Link>

    <Link :href="`/tasks/${task.id}/edit`">
        <Button label="Modifica" icon="pi pi-pencil" severity="info" size="small" />
    </Link>

    <Button
        label="Elimina"
        icon="pi pi-trash"
        severity="danger"
        size="small"
        @click="destroyTask(task.id)"
    />
</div>


                            </div>
                        </template>
                    </Card>
                </div>

                <div v-else class="flex flex-col items-start gap-4">
                    <p class="text-muted-foreground">Nessuna task associata.</p>

                    <Link :href="`/tasks/create?project_id=${project.id}`">
                        <Button label="Inserisci nuova task" icon="pi pi-plus" />
                    </Link>
                </div>
            </template>
        </Card>
    </div>
</template>