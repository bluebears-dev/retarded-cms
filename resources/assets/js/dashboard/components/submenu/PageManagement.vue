<template>
    <nav class="navbar-nav rcms-submenu">
        <a v-if="show()" @click="addPageForm" class="nav-link">
            <div class="fa fa-newspaper-o"></div>
            <span>New page</span>
        </a>
    </nav>
</template>

<script>
    export default {
        methods: {
            addPageForm: function () {
                this.$router.push({name: 'addPage'});
            },
            show() {
                return this.$store.getters['userManagement/currentUserRole'] <= 3;
            },
        }
    }
</script>