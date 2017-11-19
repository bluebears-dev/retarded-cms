<template>
    <ul class="navbar-nav mr-auto">
        <li v-for="entry in menuEntries" class="nav-item">
            <a v-on:click="loadComponent($event, entry.component)" class="nav-link">
                <div class="icon" :class="entry.icon"></div><span>{{entry.name}}</span>
            </a>
            <submenu :data="entry.submenu"></submenu>
        </li>
    </ul>
</template>

<script>
    import Submenu from './Submenu.vue'

    export default {
        components: {
            Submenu
        },
        data: function () {
            return window.store
        },
        methods: {
            loadComponent: function (event, current_component) {
                $('li', '#mainMenu').removeClass('active');
                this.$data.currentComponent = current_component;
                $('li', '#mainMenu').has(event.target)[0].classList.add('active')
            }
        }
    }
</script>