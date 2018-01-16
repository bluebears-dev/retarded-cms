export default {
    namespaced: true,
    state: {
        menu: []
    },
    mutations: {
        requestEntries(state) {
            axios({
                method: 'get',
                url: '/api/menu',
            }).then(response => {
                if (response.data && response.data.menu)
                    state.menu = response.data.menu;
            }).catch(error => {
                handleErrors(error, this.$store);
            })
        },
        requestRemoval(state, id) {
            axios({
                method: 'delete',
                url: '/api/menu/' + id,
            }).then(response => {
                if (response.data && response.data.id) {
                    let page = state.menu.find(el => el.id === response.data.id);
                    let index = state.menu.indexOf(page);
                    if (index > -1)
                        state.menu.splice(index, 1);
                }
            }).catch(error => {
                handleErrors(error, this.$store);
            })
        }
    },
    getters: {
        menu(state) {
            return state.menu;
        }
    }
}