<template>
    <nav class="navbar-nav rcms-submenu">
        <a @click="addEntryForm" class="nav-link">
            <div class="fa fa-plus"></div>
            <span>New entry</span>
        </a>
    </nav>
</template>

<script>
    export default {
        methods: {
            addEntryForm: function () {
                this.$router.push({name: 'addEntry'});
            },
        }
    }
</script>