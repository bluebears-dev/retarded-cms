<template>
    <section id="content" class="" style="width: 100px;">
        <p>{{ currentComponent }}</p>
        <div  :is="currentComponent">

        </div>
    </section>
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
        method: {
            show: function () {
                console.log(this.$data.currentComponent)
            }
        }
    };
</script>