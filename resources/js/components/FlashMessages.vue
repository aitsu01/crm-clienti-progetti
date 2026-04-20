<script setup lang="ts">
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Message from 'primevue/message';

const page = usePage();

const success = ref<string | null>(null);
const error = ref<string | null>(null);

let successTimer: ReturnType<typeof setTimeout> | null = null;
let errorTimer: ReturnType<typeof setTimeout> | null = null;

watch(
    () => page.props.flash,
    (flash: any) => {
        if (successTimer) clearTimeout(successTimer);
        if (errorTimer) clearTimeout(errorTimer);

        success.value = flash?.success ?? null;
        error.value = flash?.error ?? null;

        if (success.value) {
            successTimer = setTimeout(() => {
                success.value = null;
            }, 3000);
        }

        if (error.value) {
            errorTimer = setTimeout(() => {
                error.value = null;
            }, 4000);
        }
    },
    { immediate: true, deep: true }
);
</script>

<template>
    <div class="space-y-3">
        <Message
            v-if="success"
            severity="success"
            :closable="true"
            @close="success = null"
        >
            {{ success }}
        </Message>

        <Message
            v-if="error"
            severity="error"
            :closable="true"
            @close="error = null"
        >
            {{ error }}
        </Message>
    </div>
</template>