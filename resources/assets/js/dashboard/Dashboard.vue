<template>
    <main id="app" class="rcms-body">
        <MainMenu></MainMenu>
        <section class="rcms-screen">
            <Topbar></Topbar>
            <section id="content" class="rcms-viewport">
                <transition name="fade" duration="1000">
                    <router-view></router-view>
                </transition>
            </section>
        </section>
        <footer class="rcms-footer fixed-bottom">
            <span class="rcms-version">RetardedCMS v. 1.0.0</span>
            <span class="rcms-date">16 January 2018</span>
            <a href="https://github.com/pgorski42" class="rcms-author">Created by Paweł Górski</a>
        </footer>
    </main>
</template>

<script>
    import UsersTable from './components/user/UserView.vue'
    import MainMenu from './components/MainMenu.vue'
    import Topbar from './components/Topbar.vue'
    import Popup from './components/popup/Popup.vue'

    export default {
        components: {
            UsersTable, MainMenu, Topbar, Popup
        },
        mounted() {
            axios({
                method: 'get',
                url: '/api/user/current',
            })
            .then(response => {
                if ('currentUser' in response.data)
                    this.$store.commit('userManagement/currentUser', response.data.currentUser);
            })
            .catch(error => {
                handleErrors(error, this.$store);
            })
        }
    };
</script>