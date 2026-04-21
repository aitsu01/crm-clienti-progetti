<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Tag from 'primevue/tag';

type StatBlock = {
    clients: number;
    projects: number;
    tasks: number;
    tasks_completed: number;
    tasks_in_progress: number;
};

type RecentClient = {
    id: number;
    name: string;
    type: string;
    created_at: string | null;
};

type RecentProject = {
    id: number;
    name: string;
    status: string;
    created_at: string | null;
};

type RecentTask = {
    id: number;
    title: string;
    status: string;
    priority: string;
    created_at: string | null;
    project: {
        id: number;
        name: string;
    } | null;
};

defineProps<{
    stats: StatBlock;
    recentClients: RecentClient[];
    recentProjects: RecentProject[];
    recentTasks: RecentTask[];
}>();

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

const logout = () => {
    router.post('/logout');
};

const statusSeverity = (status: string) => {
    switch (status) {
        case 'completato':
        case 'completata':
            return 'success';
        case 'in_corso':
            return 'info';
        case 'sospeso':
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
                        Una panoramica rapida su clienti, progetti e task operative.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <Link href="/clients/create">
                        <Button label="Nuovo cliente" icon="pi pi-user-plus" />
                    </Link>

                    <Link href="/projects/create">
                        <Button
                            label="Nuovo progetto"
                            icon="pi pi-briefcase"
                            severity="secondary"
                        />
                    </Link>

                    <Link href="/tasks/create">
                        <Button
                            label="Nuova task"
                            icon="pi pi-plus"
                            severity="contrast"
                        />
                    </Link>

                    <Button
                        label="Logout"
                        icon="pi pi-sign-out"
                        severity="danger"
                        outlined
                        @click="logout"
                    />
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Clienti</div>
                        <div class="text-3xl font-bold">{{ stats.clients }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Progetti</div>
                        <div class="text-3xl font-bold">{{ stats.projects }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Task</div>
                        <div class="text-3xl font-bold">{{ stats.tasks }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Task completate</div>
                        <div class="text-3xl font-bold">{{ stats.tasks_completed }}</div>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #content>
                    <div class="space-y-2">
                        <div class="text-sm text-muted-foreground">Task in corso</div>
                        <div class="text-3xl font-bold">{{ stats.tasks_in_progress }}</div>
                    </div>
                </template>
            </Card>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <Card class="rounded-2xl shadow-sm">
                <template #title>Azioni rapide</template>
                <template #content>
                    <div class="flex flex-wrap gap-2">
                        <Link href="/clients/create">
                            <Button
                                label="Inserisci cliente"
                                icon="pi pi-user-plus"
                                size="small"
                            />
                        </Link>

                        <Link href="/projects/create">
                            <Button
                                label="Crea progetto"
                                icon="pi pi-briefcase"
                                size="small"
                                severity="secondary"
                            />
                        </Link>

                        <Link href="/tasks/create">
                            <Button
                                label="Aggiungi task"
                                icon="pi pi-plus"
                                size="small"
                                severity="success"
                            />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #title>Scorciatoie</template>
                <template #content>
                    <div class="flex flex-wrap gap-2">
                        <Link href="/clients">
                            <Button label="Vai ai clienti" size="small" outlined />
                        </Link>

                        <Link href="/projects">
                            <Button label="Vai ai progetti" size="small" outlined />
                        </Link>

                        <Link href="/tasks">
                            <Button label="Vai alle task" size="small" outlined />
                        </Link>
                    </div>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #title>Stato rapido</template>
                <template #content>
                    <div class="flex flex-wrap gap-2">
                        <Tag value="CRM operativo" severity="info" />
                        <Tag value="Task monitorate" severity="warn" />
                        <Tag value="Progetti attivi" severity="secondary" />
                    </div>
                </template>
            </Card>
        </section>

        <section class="grid gap-4 xl:grid-cols-3">
            <Card class="rounded-2xl shadow-sm">
                <template #title>Clienti recenti</template>
                <template #content>
                    <div v-if="recentClients.length" class="space-y-3">
                        <div
                            v-for="client in recentClients"
                            :key="client.id"
                            class="flex items-center justify-between rounded-xl border p-3"
                        >
                            <div>
                                <div class="font-medium">{{ client.name }}</div>
                                <div class="text-sm text-muted-foreground">
                                    {{ client.type }} · {{ client.created_at }}
                                </div>
                            </div>

                            <Link :href="`/clients/${client.id}`">
                                <Button icon="pi pi-eye" severity="secondary" rounded text />
                            </Link>
                        </div>
                    </div>

                    <p v-else class="text-sm text-muted-foreground">
                        Nessun cliente presente.
                    </p>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #title>Progetti recenti</template>
                <template #content>
                    <div v-if="recentProjects.length" class="space-y-3">
                        <div
                            v-for="project in recentProjects"
                            :key="project.id"
                            class="flex items-center justify-between rounded-xl border p-3"
                        >
                            <div>
                                <div class="font-medium">{{ project.name }}</div>
                                <div class="mt-1 flex flex-wrap gap-2">
                                    <Tag
                                        :value="project.status"
                                        :severity="statusSeverity(project.status)"
                                    />
                                </div>
                            </div>

                            <Link :href="`/projects/${project.id}`">
                                <Button icon="pi pi-eye" severity="secondary" rounded text />
                            </Link>
                        </div>
                    </div>

                    <p v-else class="text-sm text-muted-foreground">
                        Nessun progetto presente.
                    </p>
                </template>
            </Card>

            <Card class="rounded-2xl shadow-sm">
                <template #title>Task recenti</template>
                <template #content>
                    <div v-if="recentTasks.length" class="space-y-3">
                        <div
                            v-for="task in recentTasks"
                            :key="task.id"
                            class="rounded-xl border p-3"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-medium">{{ task.title }}</div>
                                    <div class="text-sm text-muted-foreground">
                                        {{ task.project?.name || 'Nessun progetto' }}
                                    </div>
                                </div>

                                <Link :href="`/tasks/${task.id}`">
                                    <Button icon="pi pi-eye" severity="secondary" rounded text />
                                </Link>
                            </div>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <Tag
                                    :value="task.status"
                                    :severity="statusSeverity(task.status)"
                                />
                                <Tag
                                    :value="task.priority"
                                    :severity="prioritySeverity(task.priority)"
                                />
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-muted-foreground">
                        Nessuna task presente.
                    </p>
                </template>
            </Card>
        </section>
    </div>
</template>