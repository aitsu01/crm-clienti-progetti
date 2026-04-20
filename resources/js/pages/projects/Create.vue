<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Card from 'primevue/card';
import DatePicker from 'primevue/datepicker';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';

type ClientOption = {
    id: number;
    name: string;
};

type StatusOption = {
    label: string;
    value: string;
};

const props = defineProps<{
    clients: ClientOption[];
    statuses: StatusOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboard() },
            { title: 'Progetti', href: '/projects' },
            { title: 'Nuovo progetto', href: '/projects/create' },
        ],
    },
});

const today = new Date().toISOString().split('T')[0];

const form = useForm({
    name: '',
    description: '',
    status: 'da_fare',
    start_date: today,
    end_date: '',
    client_ids: [] as number[],
});

const submit = () => {
    form.post('/projects');
};
</script>

<template>
    <Head title="Nuovo progetto" />

    <div class="p-4">
        <Card>
            <template #title>Nuovo progetto</template>
            <template #content>
                <form class="grid grid-cols-1 gap-6 md:grid-cols-2" @submit.prevent="submit">
                    <div class="space-y-2 md:col-span-2">
                        <label for="name" class="block text-sm font-medium">Nome progetto</label>
                        <InputText id="name" v-model="form.name" class="w-full" />
                        <small class="text-red-500">{{ form.errors.name }}</small>
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

                    <div class="space-y-2 md:col-span-2">
                        <label for="client_ids" class="block text-sm font-medium">Clienti associati</label>
                        <MultiSelect
                            id="client_ids"
                            v-model="form.client_ids"
                            :options="props.clients"
                            optionLabel="name"
                            optionValue="id"
                            filter
                            placeholder="Seleziona uno o più clienti"
                            class="w-full"
                        />
                        <small class="text-red-500">{{ form.errors.client_ids }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="start_date" class="block text-sm font-medium">Data inizio</label>
                        <InputText id="start_date" v-model="form.start_date" type="date" class="w-full" />
                        <small class="text-red-500">{{ form.errors.start_date }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="end_date" class="block text-sm font-medium">Data fine</label>
                        <InputText id="end_date" v-model="form.end_date" type="date" class="w-full" />
                        <small class="text-red-500">{{ form.errors.end_date }}</small>
                    </div>

                    <div class="flex gap-3 md:col-span-2">
                        <Button type="submit" label="Salva" :loading="form.processing" />
                        <Link href="/projects">
                            <Button type="button" label="Annulla" severity="secondary" outlined />
                        </Link>
                    </div>
                </form>
            </template>
        </Card>
    </div>
</template>