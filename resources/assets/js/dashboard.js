require('./bootstrap');

import Vue from 'vue'
import Dashboard from './app/dashboard/Dashboard.vue'


window.store = {
    currentComponent: {
        component: null,
        title: 'Dashboard'
    },
    menuEntries: [
        {
            name: 'Users',
            component: {
                component: 'UsersTable',
                title: 'User management'
            },
            icon: 'ion-person-stalker',
            submenu: [
                {
                    name: 'Add user',
                    icon: 'ion-plus',
                    route: '/api/user/'
                },
                {
                    name: 'Remove user',
                    icon: 'ion-trash-b',
                    route: '/api/user/'
                },
                {
                    name: 'Edit user',
                    icon: 'ion-edit',
                    route: '/api/user/'
                },
            ]
        },
        {
            name: 'Temporary',
            component: {
                component: 'UsersTable',
                title: 'I will be deleted in future!'
            },
            icon: 'ion-person-stalker',
            submenu: [
                {
                    name: 'Add user',
                    icon: 'ion-person-stalker',
                    route: '/api/user/'
                },
                {
                    name: 'Add user',
                    icon: 'ion-person-stalker',
                    route: '/api/user/'
                },
                {
                    name: 'Add user',
                    icon: 'ion-person-stalker',
                    route: '/api/user/'
                },
            ],
        }
    ],
    topbarEntries: [
        {
            icon: 'ion-power',
            route: '/logout'
        }
    ], // in reverse order, first will be displayed last entries
    currentUser: {
        data: null,
        role_name: function () {
            return this.data.roles[0].name
        }
    },
    selection: null,
    errors: {
        form: {}
    }
};

const app = new Vue({
    el: "#app",
    template: "<Dashboard/>",
    components: {Dashboard},
});