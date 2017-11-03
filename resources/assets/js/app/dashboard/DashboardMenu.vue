<template>
    <ul class="nav flex-column">
        <li><a v-on:click="currentComponent = 'Red'">ab</a></li>
        <li><a v-on:click="currentComponent = 'UsersList'">ab</a></li>
        <li><a v-on:click="console.log(window.store.currentComponent)">ab</a></li>
    </ul>
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
        }
    }
</script>