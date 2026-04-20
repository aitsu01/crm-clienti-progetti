<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
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
        <p class="text-sm text-muted-foreground">Gestione attività dei progetti</p>
    </div>

    <div class="flex gap-2">
        <Link href="/dashboard">
            <Button label="Dashboard" icon="pi pi-home" severity="secondary" />
        </Link>

        <Link href="/tasks/create">
            <Button label="Nuova task" icon="pi pi-plus" />
        </Link>
    </div>
</div>

        <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
            <DataTable :value="tasks" stripedRows paginator :rows="10">
                <Column field="title" header="Titolo" />
                <Column header="Progetto">
                    <template #body="{ data }">
                        {{ data.project?.name || '-' }}
                    </template>
                </Column>
                <Column header="Stato">
                    <template #body="{ data }">
                        <Tag :value="data.status" :severity="statusSeverity(data.status)" />
                    </template>
                </Column>
                <Column header="Priorità">
                    <template #body="{ data }">
                        <Tag :value="data.priority" :severity="prioritySeverity(data.priority)" />
                    </template>
                </Column>
                <Column field="due_date" header="Scadenza" />

                <Column header="Azioni">
    <template #body="{ data }">
        <div class="flex gap-2">
            <Link :href="`/tasks/${data.id}`">
                <Button label="Vedi" icon="pi pi-eye" severity="secondary" size="small" />
            </Link>

            <Link :href="`/tasks/${data.id}/edit`">
                <Button label="Modifica" icon="pi pi-pencil" severity="info" size="small" />
            </Link>

            <Button
                label="Elimina"
                icon="pi pi-trash"
                severity="danger"
                size="small"
                @click="destroyTask(data.id)"
            />
        </div>
    </template>
</Column>


            </DataTable>
        </div>
    </div>
</template>