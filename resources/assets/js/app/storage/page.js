export default {
    namespaced: true,
    state: {
        pages: null
    },
    mutations: {
        requestList(state) {
            axios({
                method: 'get',
                url: '/api/page',
            }).then(response => {
                if (response.data && response.data.pages)
                    state.pages = response.data.pages;
            }).catch(error => {
                handleErrors(error, this.$store);
            })
        },
        requestTogglingPublishedState(state, name) {
            axios({
                method: 'post',
                url: '/api/page/' + name + '/toggleState',
            }).then(response => {
                let index = state.pages.findIndex((element) => {
                    return element.name === name;
                });

                if (index === -1 || !response.data)
                    return;
                if (response.data.published !== state.pages[index].published)
                    state.pages[index].published = response.data.published;
            }).catch(error => {
                handleErrors(error, this.$store);
            })
        },
        requestRemoval(state, name) {
            axios({
                method: 'delete',
                url: '/api/page/' + name,
            }).then(response => {
                if (response.data && response.data.name) {
                    let page = state.pages.find(el => el.id === response.data.name);
                    let index = state.pages.indexOf(page);
                    if (index > -1)
                        state.pages.splice(index, 1);
                }
            }).catch(error => {
                handleErrors(error, this.$store);
            })
        }
    },
    getters: {
        pages(state) {
            return state.pages;
        }
    }
}