<template>
    <section class="rcms-options-view">
        <router-link v-for="entry in menu" :key="entry.id" tag="div" class="rcms-options-entry" :to="{ name: entry.routeName }">
            {{ entry.button }}
        </router-link>
    </section>
</template>

<script>
    export default {
        computed: {
            menu() {
                return this.$store.getters['ui/menu'];
            }
        }
    }
</script>
