<template>
    <main id="app" class="rcms-body">
        <MainMenu></MainMenu>
        <section class="rcms-screen">
            <Topbar></Topbar>
            <section id="content" class="rcms-viewport">
                <transition name="carousel" duration="1000">
                    <router-view></router-view>
                </transition>
            </section>
        </section>
        <!--<Popup id="rcms-popup" :message="this.$store.currentPopup"></Popup>-->
    </main>
</template>

<script>
    import UsersTable from './components/user/UsersTable.vue'
    import MainMenu from './components/MainMenu.vue'
    import Topbar from './components/Topbar.vue'

    export default {
        components: {
            UsersTable, MainMenu, Topbar
        },
        mounted: function () {
            axios({
                method: 'get',
                url: '/api/user/current',
            })
            .then(response => {
                if ('currentUser' in response.data)
                    this.$store.commit('userManagement/currentUser', response.data.currentUser);
            })
            .catch(error => {
                console.log(error)
            })
        }
    };
</script>