<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Tag from 'primevue/tag';

type ClientItem = {
    id: number;
    full_name: string;
};

type ProjectItem = {
    id: number;
    name: string;
    description: string | null;
    status: string;
    start_date: string | null;
    end_date: string | null;
    clients: ClientItem[];
};

defineProps<{
    projects: ProjectItem[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboard() },
            { title: 'Progetti', href: '/projects' },
        ],
    },
});

const destroyProject = (id: number) => {
    if (confirm('Sei sicuro di voler eliminare questo progetto?')) {
        router.delete(`/projects/${id}`);
    }
};

const statusSeverity = (status: string) => {
    switch (status) {
        case 'completato':
            return 'success';
        case 'in_corso':
            return 'info';
        case 'sospeso':
            return 'warn';
        default:
            return 'secondary';
    }
};
</script>

<template>
    <Head title="Progetti" />

    <div class="flex flex-1 flex-col gap-6 rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Progetti</h1>
                <p class="text-sm text-muted-foreground">Gestione progetti e clienti associati</p>
            </div>

            <Link href="/projects/create">
                <Button label="Nuovo progetto" icon="pi pi-plus" />
            </Link>
        </div>

        <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
            <DataTable :value="projects" stripedRows paginator :rows="10">
                <Column field="name" header="Nome" />

                <Column header="Stato">
                    <template #body="{ data }">
                        <Tag :value="data.status" :severity="statusSeverity(data.status)" />
                    </template>
                </Column>

                <Column field="start_date" header="Data inizio" />
                <Column field="end_date" header="Data fine" />

                <Column header="Clienti">
                    <template #body="{ data }">
                        <div class="flex flex-wrap gap-2">
                            <Tag
                                v-for="client in data.clients"
                                :key="client.id"
                                :value="client.full_name"
                                severity="secondary"
                            />
                            <span v-if="!data.clients.length">-</span>
                        </div>
                    </template>
                </Column>

                <Column header="Azioni">
                    <template #body="{ data }">
                        <div class="flex gap-2">
                            <Link :href="`/projects/${data.id}`">
                                <Button icon="pi pi-eye" severity="secondary" rounded text />
                            </Link>
                            <Link :href="`/projects/${data.id}/edit`">
                                <Button icon="pi pi-pencil" rounded text />
                            </Link>
                            <Button
                                icon="pi pi-trash"
                                severity="danger"
                                rounded
                                text
                                @click="destroyProject(data.id)"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>