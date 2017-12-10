<template>
    <section class="rcms-themes-view">
        <ThemeEntry v-for="theme in themes"
            :name="theme.name"
            :key="theme.name"
            :encodedColors="theme.colors">
        </ThemeEntry>
    </section>
</template>

<script>
    import ThemeEntry from './ThemeEntry.vue'

    export default {
        components: {ThemeEntry},
        data() {
            return {
                themes: []
            }
        },
        mounted: function () {
            axios({
                method: 'get',
                url: '/api/themes',
            })
            .then(response => {
                this.themes = response.data;
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
</script>

<style scoped>

</style>