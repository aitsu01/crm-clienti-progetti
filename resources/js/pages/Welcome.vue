<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="CRM Clienti e Progetti" />

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-900 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 dark:text-slate-100"
    >
        <header class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-6 lg:px-10">
            <div>
                <h1 class="text-xl font-bold tracking-tight">CRM Clienti, Progetti e Task</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Gestionale sviluppato con Laravel, Inertia e PrimeVue
                </p>
            </div>

            <nav class="flex items-center gap-3">
                <Link
                    v-if="$page.props.auth?.user"
                    :href="dashboard()"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium transition hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800"
                >
                    Vai alla dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="login()"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition hover:bg-slate-100 dark:hover:bg-slate-800"
                    >
                        Accedi
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200"
                    >
                        Registrati
                    </Link>
                </template>
            </nav>
        </header>

        <main class="mx-auto flex w-full max-w-7xl flex-col gap-10 px-6 py-10 lg:flex-row lg:items-center lg:px-10 lg:py-16">
            <section class="flex-1 space-y-8">
                <div class="space-y-5">
                    <span
                        class="inline-flex rounded-full border border-slate-300 px-3 py-1 text-xs font-medium uppercase tracking-wide text-slate-600 dark:border-slate-700 dark:text-slate-300"
                    >
                        CRM gestionale
                    </span>

                    <div class="space-y-4">
                        <h2 class="max-w-3xl text-4xl font-bold leading-tight md:text-5xl">
                            Gestisci clienti, progetti e task in un’unica piattaforma
                        </h2>

                        <p class="max-w-2xl text-base leading-7 text-slate-600 dark:text-slate-300 md:text-lg">
                            Un’applicazione pensata per organizzare l’anagrafica clienti,
                            assegnare progetti, monitorare task e seguire lo stato del lavoro
                            in modo chiaro, moderno e responsive.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <Link
                        v-if="$page.props.auth?.user"
                        :href="dashboard()"
                        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200"
                    >
                        Apri dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="login()"
                            class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200"
                        >
                            Accedi al CRM
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="register()"
                            class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold transition hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800"
                        >
                            Crea un account
                        </Link>
                    </template>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="mb-2 text-sm font-semibold">Clienti</div>
                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Gestione anagrafica completa di clienti privati e aziende.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="mb-2 text-sm font-semibold">Progetti</div>
                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Assegna uno o più progetti ai clienti e monitora il loro stato.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="mb-2 text-sm font-semibold">Task</div>
                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Organizza il lavoro con board per stato e drag and drop.
                        </p>
                    </div>
                </div>
            </section>

            <section class="flex-1">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl dark:border-slate-800 dark:bg-slate-900">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Panoramica gestionale</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                Una struttura pensata per il lavoro quotidiano
                            </p>
                        </div>
                        <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium dark:bg-slate-800">
                            Responsive
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="mb-2 text-sm font-semibold">Dashboard</div>
                            <p class="text-sm text-slate-600 dark:text-slate-300">
                                Accesso rapido a clienti, progetti, task e indicatori principali.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="mb-2 text-sm font-semibold">CRUD completo</div>
                            <p class="text-sm text-slate-600 dark:text-slate-300">
                                Creazione, modifica, dettaglio ed eliminazione per tutte le entità principali.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="mb-2 text-sm font-semibold">Board task</div>
                            <p class="text-sm text-slate-600 dark:text-slate-300">
                                Visualizzazione per colonne, stati, priorità e spostamento rapido.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-800">
                            <div class="mb-2 text-sm font-semibold">Validazioni</div>
                            <p class="text-sm text-slate-600 dark:text-slate-300">
                                Regole applicative gestite con Form Request e messaggi personalizzati.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
