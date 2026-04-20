<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

type ProjectItem = {
    id: number;
    name: string;
    status: string;
};

defineProps<{
    client: {
        id: number;
        first_name: string;
        last_name: string;
        full_name: string;
        type: string;
        vat_number: string | null;
        tax_code: string | null;
        address: string | null;
        email: string | null;
        projects: ProjectItem[];
    };
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
        ],
    },
});
</script>

<template>
    <Head :title="client.full_name" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ client.full_name }}</h1>

            <div class="flex gap-2">
                <Link :href="`/clients/${client.id}/edit`">
                    <Button label="Modifica" icon="pi pi-pencil" />
                </Link>
                <Link href="/clients">
                    <Button label="Torna alla lista" severity="secondary" outlined />
                </Link>
            </div>
        </div>

        <Card>
            <template #content>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div><strong>Tipo:</strong> {{ client.type }}</div>
                    <div><strong>Email:</strong> {{ client.email || '-' }}</div>
                    <div><strong>Partita IVA:</strong> {{ client.vat_number || '-' }}</div>
                    <div><strong>Codice fiscale:</strong> {{ client.tax_code || '-' }}</div>
                    <div class="md:col-span-2"><strong>Indirizzo:</strong> {{ client.address || '-' }}</div>
                </div>
            </template>
        </Card>

        <Card>
            <template #title>Progetti assegnati</template>
            <template #content>
                <div v-if="client.projects.length" class="flex flex-wrap gap-2">
                    <Tag
                        v-for="project in client.projects"
                        :key="project.id"
                        :value="`${project.name} (${project.status})`"
                        severity="secondary"
                    />
                </div>
                <p v-else>Nessun progetto assegnato.</p>
            </template>
        </Card>
    </div>
</template>