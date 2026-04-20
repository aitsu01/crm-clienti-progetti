<script setup lang="ts">
import { computed, ref } from 'vue';
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

type StatusItem = {
    label: string;
    value: string;
};

const props = defineProps<{
    tasks: TaskItem[];
    statuses: StatusItem[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboard() },
            { title: 'Task', href: '/tasks' },
        ],
    },
});

const draggedTaskId = ref<number | null>(null);
const hoveredColumn = ref<string | null>(null);

const destroyTask = (id: number) => {
    if (confirm('Sei sicuro di voler eliminare questa task?')) {
        router.delete(`/tasks/${id}`);
    }
};

const groupedTasks = computed(() => {
    return props.statuses.map((status) => ({
        ...status,
        tasks: props.tasks.filter((task) => task.status === status.value),
    }));
});

const onDragStart = (taskId: number) => {
    draggedTaskId.value = taskId;
};

const onDragEnd = () => {
    draggedTaskId.value = null;
    hoveredColumn.value = null;
};

const onDragEnterColumn = (status: string) => {
    hoveredColumn.value = status;
};

const onDragLeaveColumn = () => {
    hoveredColumn.value = null;
};

const moveTaskToStatus = (status: string) => {
    if (!draggedTaskId.value) return;

    const draggedTask = props.tasks.find((task) => task.id === draggedTaskId.value);
    if (!draggedTask) return;

    if (draggedTask.status === status) {
        hoveredColumn.value = null;
        draggedTaskId.value = null;
        return;
    }

    router.patch(
        `/tasks/${draggedTask.id}/status`,
        { status },
        {
            preserveScroll: true,
            onFinish: () => {
                hoveredColumn.value = null;
                draggedTaskId.value = null;
            },
        }
    );
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

const columnClasses = (status: string) => {
    const base =
        'rounded-2xl border p-3 transition-all duration-200 min-h-[420px]';

    const colors: Record<string, string> = {
        da_fare: 'border-slate-300 bg-slate-50 dark:border-slate-700 dark:bg-slate-900/40',
        in_corso: 'border-blue-300 bg-blue-50 dark:border-blue-700 dark:bg-blue-950/30',
        in_revisione: 'border-amber-300 bg-amber-50 dark:border-amber-700 dark:bg-amber-950/30',
        completata: 'border-green-300 bg-green-50 dark:border-green-700 dark:bg-green-950/30',
        bloccata: 'border-red-300 bg-red-50 dark:border-red-700 dark:bg-red-950/30',
    };

    const active =
        hoveredColumn.value === status
            ? ' ring-2 ring-primary/50 scale-[1.01]'
            : '';

    return `${base} ${colors[status] ?? ''}${active}`;
};
</script>

<template>
    <Head title="Task" />

    <div class="flex flex-1 flex-col gap-6 rounded-xl p-4 md:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold">Task</h1>
                <p class="text-sm text-muted-foreground">
                    Trascina le task tra le colonne per aggiornare lo stato
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <Link href="/dashboard">
                    <Button label="Dashboard" icon="pi pi-home" severity="secondary" />
                </Link>

                <Link href="/tasks/create">
                    <Button label="Inserisci nuova task" icon="pi pi-plus" />
                </Link>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2">
            <div
                v-for="column in groupedTasks"
                :key="column.value"
                :class="columnClasses(column.value)"
                @dragover.prevent
                @dragenter.prevent="onDragEnterColumn(column.value)"
                @dragleave="onDragLeaveColumn"
                @drop.prevent="moveTaskToStatus(column.value)"
            >
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="font-semibold">{{ column.label }}</div>
                    <Tag :value="String(column.tasks.length)" severity="secondary" />
                </div>

                <div v-if="column.tasks.length" class="space-y-4">

                    <Card
    v-for="task in column.tasks"
    :key="task.id"
    class="h-full cursor-grab rounded-2xl border shadow-sm transition hover:shadow-md active:cursor-grabbing"
    draggable="true"
    @dragstart="onDragStart(task.id)"
    @dragend="onDragEnd"
>
    <template #content>
        <div class="flex min-h-[320px] flex-col gap-4">
            <div>
                <div class="mb-1 text-xs font-medium uppercase tracking-wide text-muted-foreground">
                    {{ task.project?.name || 'Nessun progetto' }}
                </div>

                <h3 class="line-clamp-2 min-h-[3.5rem] text-base font-semibold leading-7">
                    {{ task.title }}
                </h3>
            </div>

            <p class="line-clamp-4 min-h-[6rem] text-sm leading-6 text-muted-foreground">
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

            <div class="mt-auto grid grid-cols-3 gap-2 pt-2">
                <Link :href="`/tasks/${task.id}`" class="w-full">
                    <Button
                        label="Vedi"
                        icon="pi pi-eye"
                        severity="secondary"
                        size="small"
                        class="w-full justify-center"
                    />
                </Link>

                <Link :href="`/tasks/${task.id}/edit`" class="w-full">
                    <Button
                        label="Modifica"
                        icon="pi pi-pencil"
                        severity="info"
                        size="small"
                        class="w-full justify-center"
                    />
                </Link>

                <Button
                    label="Elimina"
                    icon="pi pi-trash"
                    severity="danger"
                    size="small"
                    class="w-full justify-center"
                    @click="destroyTask(task.id)"
                />
            </div>
        </div>
    </template>
</Card>        
                    
                  



                </div>

                <div v-else class="text-sm text-muted-foreground">
                    Nessuna task in questa colonna.
                </div>
            </div>
        </div>
    </div>
</template>