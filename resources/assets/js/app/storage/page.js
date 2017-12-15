export default {
    namespaced: true,
    state: {
        pages: null
    },
    mutations: {
        savePageData(state, data) {
            state.autosavedPageData = data
        },
        requestList(state) {
            axios({
                method: 'get',
                url: '/api/page',
            }).then(response => {
                if (response.data)
                    state.pages = response.data;
            }).catch(error => {
                console.log(error);
            })
        },
    },
    getters: {
        pageData(state) {
            return state.autosavedPageData
        },
        pages(state) {
            return state.pages;
        }
    }
}