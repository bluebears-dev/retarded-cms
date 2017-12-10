require('./bootstrap');

import Vue from 'vue'
import Dashboard from './app/dashboard/Dashboard.vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

import Blank from './app/dashboard/components/Blank.vue';

import UsersTable from './app/dashboard/components/user/UsersTable.vue';
import AddUserView from './app/dashboard/components/user/AddUserView.vue'

import BlankSubmenu from './app/dashboard/components/menu/submenu/Blank.vue'
import BackSubmenu from './app/dashboard/components/menu/submenu/Back.vue'
import UserManagementSubmenu from './app/dashboard/components/menu/submenu/UserManagement.vue'

import Options from './app/dashboard/components/options/Options.vue';
import ThemesView from './app/dashboard/components/options/entries/Themes.vue';

Vue.use(Vuex);
Vue.use(VueRouter);

const moduleUi = {
    state: {
        menuEntries: [
            {
                button: 'User Management',
                routeName: 'users',
                icon: 'ion-person-stalker',
            },
            {
                button: 'Blank',
                routeName: 'blank',
                icon: 'ion-person-stalker',
            }
        ],
        topbarEntries: [
            {
                icon: 'ion-power',
                route: '/logout'
            },
            {
                icon: 'ion-gear-b',
                route: '/dashboard#/options'
            }
        ], // in reverse order
    },
    getters: {
        menu(state) {
            return state.menuEntries;
        },
        topbar(state) {
            return state.topbarEntries;
        }
    }
};

const moduleUserManagement = {
    namespaced: true,
    state: {
        selectedUser: null,
        users: null,
        roles: null,
        updatedUsers: {}
    },
    mutations: {
        select(state, user) {
            state.selectedUser = user;
        },
        store(state, users) {
            state.users = users;
        },
        requestUserList(state) {
            axios({
                method: 'get',
                url: '/api/user',
            }).then(response => {
                if (response.data.users)
                    state.users = response.data.users;
            }).catch(error => {
                console.log(error);
            })
        },
        requestUserRemoval(state, user) {
            axios({
                method: 'delete',
                url: '/api/user/' + user,
            }).then(response => {
                let user = state.users.find(el => el.id === response.data);
                let index = state.users.indexOf(user);
                if (index > -1)
                    state.users.splice(index, 1);
            }).catch(error => {
                console.log(error);
            })
        },
        requestUserUpdate(state) {
            console.log(state.updatedUsers)
            for (let login in state.updatedUsers) {
                axios({
                    method: 'put',
                    url: '/api/user/' + state.updatedUsers[login][1],
                    data: {
                        role: state.updatedUsers[login][0]
                    }
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error)
                })
            }
            state.updatedUsers = {};
        },
        stageChange(state, data) {
            let user = data[0];
            let role = data[1];
            state.updatedUsers[user.login] = [role, user.id];
        },
        unstageChange(state, user) {
            delete state.updatedUsers[user.login];
        }
    },
    getters: {
        selected(state) {
            return state.selectedUser;
        },
        users(state) {
            if (state.users === null) {
                axios({
                    method: 'get',
                    url: '/api/user',
                }).then(response => {
                    if (response.data.users)
                        state.users = response.data.users;
                }).catch(error => {
                    console.log(error);
                })
            }
            return state.users;
        },
        roles(state) {
            if (state.roles === null) {
                axios({
                    method: 'get',
                    url: '/api/user/roles',
                }).then(response => {
                    if (response.data.roles)
                        state.roles = response.data.roles;
                }).catch(error => {
                    console.log(error);
                })
            }
            return state.roles;
        }
    }
};

const moduleMain = {
    state: {
        currentUser: {},
        currentPopup: null
    },
    mutations: {
        user(state, user) {
            state.currentUser = user;
        },
    },
    getters: {
        userRole(state) {
            if (state.currentUser.roles)
                return state.currentUser.roles[0].id;
        },
        currentTheme(state) {
            if (state.currentUser.theme)
                return state.currentUser.theme;
        }
    }
};

const store = new Vuex.Store({
    modules: {
        ui: moduleUi,
        main: moduleMain,
        userManagement: moduleUserManagement,
    }
});

const routes = [
    {
        path: '/users',
        name: 'users',
        components: {
            default: UsersTable,
            title: { template: '<h1>User Management</h1>' },
            submenu: UserManagementSubmenu
        }
    },
    {
        path: '/blank',
        name: 'blank',
        components: {
            default: Blank,
            title: { template: '<h1>Blank</h1>' },
            submenu: BlankSubmenu
        }
    },
    {
        path: '/',
        name: 'main',
        components: {
            default: Blank,
            title: { template: '<h1>&nbsp;</h1>' },
            submenu: BlankSubmenu
        }
    },
    {
        path: '/users/add',
        name: 'addUserView',
        components: {
            default: AddUserView,
            title: { template: '<h1>Add User</h1>' },
            submenu: BackSubmenu
        }
    },
    {
        path: '/options',
        name: 'options',
        components: {
            default: Options,
            title: { template: '<h1>Options</h1>' },
            submenu: BackSubmenu
        }
    },
    {
        path: '/options/themes',
        name: 'themes',
        components: {
            default: ThemesView,
            title: { template: '<h1>Dashboard Themes</h1>' },
            submenu: BackSubmenu
        }
    }
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: "#app",
    store,
    router,
    template: "<Dashboard/>",
    components: {Dashboard},
});