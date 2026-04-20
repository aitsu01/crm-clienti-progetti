<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Tag from 'primevue/tag';

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

defineProps<{
    stats?: {
        clients?: number;
        projects?: number;
        tasks?: number;
        tasks_completed?: number;
        tasks_in_progress?: number;
    };
}>();
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 md:p-6">
        <section
            class="rounded-2xl border border-sidebar-border/70 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-5 text-white shadow-sm dark:border-sidebar-border"
        >
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <h1 class="text-2xl font-bold md:text-3xl">Dashboard gestionale</h1>
                    <p class="mt-2 text-sm text-slate-200 md:text-base">
                        Gestisci clienti, progetti e task da un’unica area operativa.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <Link href="/clients/create">
                        <Button label="Nuovo cliente" icon="pi pi-user-plus" />
                    </Link>
                    <Link href="/projects/create">
                        <Button label="Nuovo progetto" icon="pi pi-briefcase" severity="secondary" />
                    </Link>
                    <Link href="/tasks/create">
                        <Button label="Nuova task" icon="pi pi-plus" severity="contrast" />
                    </Link>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Clienti</div>
                        <div class="text-3xl font-bold">{{ stats?.clients ?? 0 }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Progetti</div>
                        <div class="text-3xl font-bold">{{ stats?.projects ?? 0 }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Task</div>
                        <div class="text-3xl font-bold">{{ stats?.tasks ?? 0 }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Task completate</div>
                        <div class="text-3xl font-bold">{{ stats?.tasks_completed ?? 0 }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Task in corso</div>
                        <div class="text-3xl font-bold">{{ stats?.tasks_in_progress ?? 0 }}</div>
                    </div>
                </template>
            </Card>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <Card class="rounded-2xl shadow-sm">
                <template #title>Clienti</template>
                <template #content>
                    <p class="mb-4 text-sm text-muted-foreground">
                        Accedi alla gestione anagrafica, modifica dati e assegna progetti.
                    </p>

                    <div class="flex flex-wrap gap-2">
                        <Link href="/clients">
                            <Button label="Apri clienti" icon="pi pi-users" />
                        </Link>
                        <Link href="/clients/create">
                            <Button label="Nuovo" icon="pi pi-plus" severity="secondary" />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #title>Progetti</template>
                <template #content>
                    <p class="mb-4 text-sm text-muted-foreground">
                        Monitora progetti, clienti associati e task collegate.
                    </p>

                    <div class="flex flex-wrap gap-2">
                        <Link href="/projects">
                            <Button label="Apri progetti" icon="pi pi-briefcase" />
                        </Link>
                        <Link href="/projects/create">
                            <Button label="Nuovo" icon="pi pi-plus" severity="secondary" />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #title>Task</template>
                <template #content>
                    <p class="mb-4 text-sm text-muted-foreground">
                        Gestisci attività, stati, priorità e scadenze in modo rapido.
                    </p>

                    <div class="flex flex-wrap gap-2">
                        <Link href="/tasks">
                            <Button label="Apri task" icon="pi pi-list-check" />
                        </Link>
                        <Link href="/tasks/create">
                            <Button label="Nuova" icon="pi pi-plus" severity="secondary" />
                        </Link>
                    </div>
                </template>
            </Card>
        </section>

        <section class="grid gap-4 xl:grid-cols-2">
            <Card class="rounded-2xl shadow-sm">
                <template #title>Stato rapido</template>
                <template #content>
                    <div class="flex flex-wrap gap-2">
                        <Tag value="Clienti attivi" severity="info" />
                        <Tag value="Progetti monitorati" severity="secondary" />
                        <Tag value="Task operative" severity="warn" />
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #title>Azioni suggerite</template>
                <template #content>
                    <div class="flex flex-wrap gap-2">
                        <Link href="/clients/create">
                            <Button label="Inserisci cliente" size="small" />
                        </Link>
                        <Link href="/projects/create">
                            <Button label="Crea progetto" size="small" severity="secondary" />
                        </Link>
                        <Link href="/tasks/create">
                            <Button label="Aggiungi task" size="small" severity="success" />
                        </Link>
                    </div>
                </template>
            </Card>
        </section>
    </div>
</template>