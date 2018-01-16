<template>
    <nav class="navbar-nav rcms-submenu">
        <a v-on:click="back" class="nav-link">
            <div class="fa fa-arrow-left"></div>
            <span>Back</span>
        </a>
    </nav>
</template>

<script>
    export default {
        methods: {
            back: function () {
                this.$router.go(-1);
            }
        }
    }
</script>