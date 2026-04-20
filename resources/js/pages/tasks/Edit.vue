<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';

type ProjectOption = {
    id: number;
    name: string;
};

type OptionItem = {
    label: string;
    value: string;
};

type TaskForm = {
    id: number;
    project_id: number;
    title: string;
    description: string | null;
    status: string;
    priority: string;
    due_date: string | null;
};

const props = defineProps<{
    task: TaskForm;
    projects: ProjectOption[];
    statuses: OptionItem[];
    priorities: OptionItem[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboard() },
            { title: 'Task', href: '/tasks' },
            { title: 'Modifica task', href: '/tasks' },
        ],
    },
});

const form = useForm({
    project_id: props.task.project_id ?? null,
    title: props.task.title ?? '',
    description: props.task.description ?? '',
    status: props.task.status ?? 'da_fare',
    priority: props.task.priority ?? 'media',
    due_date: props.task.due_date ?? '',
});

const submit = () => {
    form.put(`/tasks/${props.task.id}`);
};
</script>

<template>
    <Head title="Modifica task" />

    <div class="p-4">
        <Card>
            <template #title>Modifica task</template>
            <template #content>
                <form class="grid grid-cols-1 gap-6 md:grid-cols-2" @submit.prevent="submit">
                    <div class="space-y-2 md:col-span-2">
                        <label for="project_id" class="block text-sm font-medium">Progetto</label>
                        <Select
                            id="project_id"
                            v-model="form.project_id"
                            :options="props.projects"
                            optionLabel="name"
                            optionValue="id"
                            class="w-full"
                        />
                        <small class="text-red-500">{{ form.errors.project_id }}</small>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="title" class="block text-sm font-medium">Titolo task</label>
                        <InputText id="title" v-model="form.title" class="w-full" />
                        <small class="text-red-500">{{ form.errors.title }}</small>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="description" class="block text-sm font-medium">Descrizione</label>
                        <Textarea id="description" v-model="form.description" rows="4" class="w-full" />
                        <small class="text-red-500">{{ form.errors.description }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-medium">Stato</label>
                        <Select
                            id="status"
                            v-model="form.status"
                            :options="props.statuses"
                            optionLabel="label"
                            optionValue="value"
                            class="w-full"
                        />
                        <small class="text-red-500">{{ form.errors.status }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="priority" class="block text-sm font-medium">Priorità</label>
                        <Select
                            id="priority"
                            v-model="form.priority"
                            :options="props.priorities"
                            optionLabel="label"
                            optionValue="value"
                            class="w-full"
                        />
                        <small class="text-red-500">{{ form.errors.priority }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="due_date" class="block text-sm font-medium">Scadenza</label>
                        <InputText id="due_date" v-model="form.due_date" type="date" class="w-full" />
                        <small class="text-red-500">{{ form.errors.due_date }}</small>
                    </div>

                    <div class="flex gap-3 md:col-span-2">
                        <Button type="submit" label="Aggiorna" :loading="form.processing" />
                        <Link href="/tasks">
                            <Button type="button" label="Annulla" severity="secondary" outlined />
                        </Link>
                    </div>
                </form>
            </template>
        </Card>
    </div>
</template>