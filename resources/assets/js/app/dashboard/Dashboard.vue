<template>
    <main id="app" class="rcms-body">
        <nav class="navbar rcms-menu" id="mainMenu">
            <div class="rcms-logo">R</div>
            <div>
                <MainMenu></MainMenu>
            </div>
        </nav>
        <section class="rcms-screen">
            <Topbar :componentTitle="currentComponent.title"></Topbar>
            <section id="content" class="rcms-viewport">
                <div :is="currentComponent.component">

                </div>
            </section>
        </section>
    </main>
</template>

<script>
    import UsersTable from './components/UsersTable.vue'
    import MainMenu from './components/MainMenu.vue'
    import Topbar from './components/Topbar.vue'

    export default {
        components: {
            UsersTable, MainMenu, Topbar
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
                if ('currentUser' in response.data)
                    this.$data.currentUser.data = response.data.currentUser;
            })
            .catch(error => {

            })
        }
    };
</script>