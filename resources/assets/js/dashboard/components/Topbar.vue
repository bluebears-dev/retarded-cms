<template>
    <header class="navbar rcms-topbar">
        <transition name="fade">
            <router-view :key="title" class="rcms-title" name="title"></router-view>
        </transition>
        <nav class="nav">
            <a v-for="entry in topbar" class="nav-link" :href="entry.route">
                <span class="icon" :class="entry.icon"></span>
            </a>
        </nav>
    </header>
</template>

<script>
    export default {
        computed: {
            topbar: function () {
                return this.$store.getters['ui/topbar'];
            }
        },
        props: ['title']
    }
</script>