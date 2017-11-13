<template>
    <section id="content" class="rcms-view">
        <p>{{ currentComponent }}</p>
        <div :is="currentComponent">

        </div>
    </section>
</template>

<script>
    import UsersList from './components/UsersList.vue'
    import Red from './components/Red.vue'

    export default {
        components: {
            UsersList
        },
        data: function () {
            return window.store
        },
        mounted: function () {
            axios({
                method: 'get',
                url: '/api/user/current',
            })
            .then(response => {
                console.log(response)
                if ('currentUser' in response.data)
                    this.$data.currentUser.data = response.data.currentUser;
            })
            .catch(error => {

            })
        }
    };
</script>