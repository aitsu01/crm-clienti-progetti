<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

type ProjectItem = {
    id: number;
    name: string;
};

type TaskItem = {
    id: number;
    title: string;
    description: string | null;
    status: string;
    priority: string;
    due_date: string | null;
    project: ProjectItem | null;
};

defineProps<{
    tasks: TaskItem[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboard() },
            { title: 'Task', href: '/tasks' },
        ],
    },
});

const destroyTask = (id: number) => {
    if (confirm('Sei sicuro di voler eliminare questa task?')) {
        router.delete(`/tasks/${id}`);
    }
};

const statusSeverity = (status: string) => {
    switch (status) {
        case 'completata':
            return 'success';
        case 'in_corso':
            return 'info';
        case 'in_revisione':
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
</script>

<template>
    <Head title="Task" />

    <div class="flex flex-1 flex-col gap-6 rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Task</h1>
                <p class="text-sm text-muted-foreground">
                    Gestione attività dei progetti
                </p>
            </div>

            <div class="flex gap-2">
                <Link href="/dashboard">
                    <Button label="Dashboard" icon="pi pi-home" severity="secondary" />
                </Link>

                <Link href="/tasks/create">
                    <Button label="Inserisci nuova task" icon="pi pi-plus" />
                </Link>
            </div>
        </div>

        <div v-if="tasks.length" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <Card
                v-for="task in tasks"
                :key="task.id"
                class="h-full"
            >
                <template #title>
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm text-muted-foreground">
                                {{ task.project?.name || 'Nessun progetto' }}
                            </div>
                            <div class="text-lg font-semibold">
                                {{ task.title }}
                            </div>
                        </div>
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

        <Card v-else>
            <template #content>
                <div class="flex flex-col items-start gap-4">
                    <p class="text-muted-foreground">
                        Non ci sono ancora task inserite.
                    </p>

                    <Link href="/tasks/create">
                        <Button label="Inserisci nuova task" icon="pi pi-plus" />
                    </Link>
                </div>
            </template>
        </Card>
    </div>
</template>