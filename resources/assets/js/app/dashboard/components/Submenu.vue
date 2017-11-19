<template>
    <ul class="navbar-nav rcms-submenu">
        <li v-for="value in data" class="nav-item">
            <a class="nav-link">
                <div class="icon" :class="value.icon"></div><span>{{value.name}}</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['data']
    }
</script>