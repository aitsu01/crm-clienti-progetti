<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import Message from 'primevue/message';

const page = usePage();
</script>

<template>
    <div class="space-y-4">
        <Message v-if="page.props.flash?.success" severity="success">
            {{ page.props.flash.success }}
        </Message>

        <Message v-if="page.props.flash?.error" severity="error">
            {{ page.props.flash.error }}
        </Message>

        <slot />
    </div>
</template>
