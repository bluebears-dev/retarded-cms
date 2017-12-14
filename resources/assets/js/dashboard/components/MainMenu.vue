<template>
    <nav class="navbar rcms-menu" id="mainMenu">
        <div class="rcms-logo">R</div>
        <nav class="navbar-nav mr-auto">
            <router-link v-for="entry in menu" :key="entry.routeName" class="nav-link" :to="{ name: entry.routeName}">
                <div>{{ entry.button }}</div>
            </router-link>
        </nav>
        <section class="rcms-menu-bottom">
            <h5>Actions</h5>
            <router-view name="submenu"></router-view>
        </section>
    </nav>
</template>

<script>
    export default {
        computed: {
            menu: function () {
                return this.$store.getters['ui/menu'];
            }
        }
    }
</script>