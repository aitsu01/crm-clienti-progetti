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

type ClientItem = {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    type: 'privato' | 'azienda';
    vat_number: string | null;
    tax_code: string | null;
    address: string | null;
    email: string | null;
    projects: ProjectItem[];
};

defineProps<{
    clients: ClientItem[];
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

const destroyClient = (id: number) => {
    if (confirm('Sei sicuro di voler eliminare questo cliente?')) {
        router.delete(`/clients/${id}`);
    }
};

const typeSeverity = (type: string) => {
    return type === 'azienda' ? 'info' : 'contrast';
};
</script>

<template>
    <Head title="Clienti" />

    <div class="flex flex-1 flex-col gap-6 rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Clienti</h1>
                <p class="text-sm text-muted-foreground">
                    Gestione anagrafica clienti e progetti assegnati
                </p>
            </div>

            <Link href="/clients/create">
                <Button label="Nuovo cliente" icon="pi pi-plus" />
            </Link>
        </div>

        <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
            <DataTable :value="clients" stripedRows paginator :rows="10">
                <Column field="full_name" header="Cliente" />

                <Column header="Tipo">
                    <template #body="{ data }">
                        <Tag :value="data.type" :severity="typeSeverity(data.type)" />
                    </template>
                </Column>

                <Column header="P.IVA / C.F.">
                    <template #body="{ data }">
                        {{ data.vat_number || data.tax_code || '-' }}
                    </template>
                </Column>

                <Column field="email" header="Email" />
                <Column field="address" header="Indirizzo" />

                <Column header="Progetti">
                    <template #body="{ data }">
                        <div class="flex flex-wrap gap-2">
                            <Tag
                                v-for="project in data.projects"
                                :key="project.id"
                                :value="project.name"
                                severity="secondary"
                            />
                            <span v-if="!data.projects.length">-</span>
                        </div>
                    </template>
                </Column>

                <Column header="Azioni">
                    <template #body="{ data }">
                        <div class="flex gap-2">
                            <Link :href="`/clients/${data.id}`">
                                <Button icon="pi pi-eye" severity="secondary" rounded text />
                            </Link>

                            <Link :href="`/clients/${data.id}/edit`">
                                <Button icon="pi pi-pencil" rounded text />
                            </Link>

                            <Button
                                icon="pi pi-trash"
                                severity="danger"
                                rounded
                                text
                                @click="destroyClient(data.id)"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>