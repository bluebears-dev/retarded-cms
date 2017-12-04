<template>
    <transition name="fade">
        <nav class="navbar-nav rcms-submenu">
            <a v-on:click="back" class="nav-link">
                <div class="icon ion-arrow-left-a"></div><span>Back</span>
            </a>
        </nav>
    </transition>
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