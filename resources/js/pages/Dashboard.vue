<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Card from 'primevue/card';
import Button from 'primevue/button';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
        <div>
            <h1 class="text-2xl font-bold">Dashboard gestionale</h1>
            <p class="text-sm text-gray-500">
                Accesso rapido a clienti, progetti e task.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <Card>
                <template #title>Clienti</template>
                <template #content>
                    <p class="mb-4 text-sm text-gray-600">
                        Gestisci anagrafica clienti e assegnazione progetti.
                    </p>
                    <div class="flex gap-2">
                        <Link href="/clients">
                            <Button label="Apri" icon="pi pi-users" />
                        </Link>
                        <Link href="/clients/create">
                            <Button label="Nuovo" icon="pi pi-plus" severity="secondary" />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Progetti</template>
                <template #content>
                    <p class="mb-4 text-sm text-gray-600">
                        Gestisci i progetti e i clienti associati.
                    </p>
                    <div class="flex gap-2">
                        <Link href="/projects">
                            <Button label="Apri" icon="pi pi-briefcase" />
                        </Link>
                        <Link href="/projects/create">
                            <Button label="Nuovo" icon="pi pi-plus" severity="secondary" />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Task</template>
                <template #content>
                    <p class="mb-4 text-sm text-gray-600">
                        Monitora attività, priorità e scadenze.
                    </p>
                    <div class="flex gap-2">
                        <Link href="/tasks">
                            <Button label="Apri" icon="pi pi-list-check" />
                        </Link>
                        <Link href="/tasks/create">
                            <Button label="Nuova" icon="pi pi-plus" severity="secondary" />
                        </Link>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>