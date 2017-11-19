<template>
    <header class="navbar rcms-topbar">
        <h2 class="rcms-title">{{componentTitle}}</h2>
        <nav class="nav">
            <a v-for="entry in topbarEntries" class="nav-link" :href="entry.route">
                <span class="icon" :class="entry.icon"></span>
            </a>
        </nav>
    </header>
</template>

<script>
    export default {
        data: function () {
            return window.store
        },
        props: ['componentTitle']
    }
</script>