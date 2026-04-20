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
                Accedi rapidamente a clienti, progetti e task.
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
                        <Link :href="route('clients.index')">
                            <Button label="Vai ai clienti" icon="pi pi-users" />
                        </Link>
                        <Link :href="route('clients.create')">
                            <Button label="Nuovo" icon="pi pi-plus" severity="secondary" />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Progetti</template>
                <template #content>
                    <p class="mb-4 text-sm text-gray-600">
                        Gestisci i progetti e il loro stato.
                    </p>
                    <div class="flex gap-2">
                        <Link :href="route('projects.index')">
                            <Button label="Vai ai progetti" icon="pi pi-briefcase" />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Task</template>
                <template #content>
                    <p class="mb-4 text-sm text-gray-600">
                        Monitora le task associate ai progetti.
                    </p>
                    <div class="flex gap-2">
                        <Link :href="route('tasks.index')">
                            <Button label="Vai alle task" icon="pi pi-list-check" />
                        </Link>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>