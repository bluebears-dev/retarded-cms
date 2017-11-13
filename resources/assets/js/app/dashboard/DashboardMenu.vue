<template>
    <nav class="navbar navbar-expand-sm rcms-menu">
        <a class="navbar-brand rcms-logo">R</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <button class="navbar-toggler-icon">
            <span></span><span></span><span></span><span></span>
        </button>
        </button>
        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav mr-auto">
                <li v-for="(current_component, name) in menuEntries" class="nav-item">
                    <a v-on:click="setActive($event, current_component)" class="nav-link">
                        {{ name }}
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import UsersList from './components/UsersList.vue'
    import Red from './components/Red.vue'

    export default {
        components: {
            UsersList, Red
        },
        data: function () {
            return window.store
        },
        methods: {
            setActive: function (event, current_component) {
                $('li', '#mainMenu').removeClass('active');
                this.$data.currentComponent = current_component;
                event.target.classList.add('active');
            }
        }
    }
</script>