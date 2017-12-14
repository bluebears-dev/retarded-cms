export default {
    namespaced: true,
    state: {
        menuEntries: [
            {
                button: 'User Management',
                routeName: 'users',
            },
            {
                button: 'Pages',
                routeName: 'pages',
            }
        ],
        topbarEntries: [
            {
                icon: 'fa fa-power-off',
                route: '/logout'
            },
            {
                icon: 'fa fa-gear',
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