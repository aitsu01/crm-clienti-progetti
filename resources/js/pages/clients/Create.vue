<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Select from 'primevue/select';

type ProjectOption = {
    id: number;
    name: string;
};

type TypeOption = {
    label: string;
    value: 'privato' | 'azienda';
};

const props = defineProps<{
    projects: ProjectOption[];
    clientTypes: TypeOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
            {
                title: 'Clienti',
                href: '/clients',
            },
            {
                title: 'Nuovo cliente',
                href: '/clients/create',
            },
        ],
    },
});

const form = useForm({
    first_name: '',
    last_name: '',
    type: 'privato',
    vat_number: '',
    tax_code: '',
    address: '',
    email: '',
    project_ids: [] as number[],
});

const submit = () => {
    form.post('/clients');
};
</script>

<template>
    <Head title="Nuovo cliente" />

    <div class="p-4">
        <Card>
            <template #title>Nuovo cliente</template>
            <template #content>
                <form class="grid grid-cols-1 gap-6 md:grid-cols-2" @submit.prevent="submit">
                    <div class="space-y-2">
                        <label for="first_name" class="block text-sm font-medium">Nome</label>
                        <InputText id="first_name" v-model="form.first_name" class="w-full" />
                        <small class="text-red-500">{{ form.errors.first_name }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="last_name" class="block text-sm font-medium">Cognome</label>
                        <InputText id="last_name" v-model="form.last_name" class="w-full" />
                        <small class="text-red-500">{{ form.errors.last_name }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="type" class="block text-sm font-medium">Tipo cliente</label>
                        <Select
                            id="type"
                            v-model="form.type"
                            :options="props.clientTypes"
                            optionLabel="label"
                            optionValue="value"
                            class="w-full"
                        />
                        <small class="text-red-500">{{ form.errors.type }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <InputText id="email" v-model="form.email" class="w-full" />
                        <small class="text-red-500">{{ form.errors.email }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="vat_number" class="block text-sm font-medium">Partita IVA</label>
                        <InputText id="vat_number" v-model="form.vat_number" class="w-full" />
                        <small class="text-red-500">{{ form.errors.vat_number }}</small>
                    </div>

                    <div class="space-y-2">
                        <label for="tax_code" class="block text-sm font-medium">Codice fiscale</label>
                        <InputText id="tax_code" v-model="form.tax_code" class="w-full" />
                        <small class="text-red-500">{{ form.errors.tax_code }}</small>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="address" class="block text-sm font-medium">Indirizzo</label>
                        <InputText id="address" v-model="form.address" class="w-full" />
                        <small class="text-red-500">{{ form.errors.address }}</small>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="project_ids" class="block text-sm font-medium">Progetti assegnati</label>
                        <MultiSelect
                            id="project_ids"
                            v-model="form.project_ids"
                            :options="props.projects"
                            optionLabel="name"
                            optionValue="id"
                            filter
                            placeholder="Seleziona uno o più progetti"
                            class="w-full"
                        />
                        <small class="text-red-500">{{ form.errors.project_ids }}</small>
                    </div>

                    <div class="flex gap-3 md:col-span-2">
                        <Button type="submit" label="Salva" :loading="form.processing" />
                        <Link href="/clients">
                            <Button type="button" label="Annulla" severity="secondary" outlined />
                        </Link>
                    </div>
                </form>
            </template>
        </Card>
    </div>
</template>