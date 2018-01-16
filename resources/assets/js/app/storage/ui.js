export default {
    namespaced: true,
    state: {
        menuEntries: [
            {
                button: 'User management',
                routeName: 'users',
            },
            {
                button: 'Pages',
                routeName: 'pages',
            },
            {
                button: 'Chat',
                routeName: 'chat',
            },
            {
                button: 'Menu management',
                routeName: 'menu',
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