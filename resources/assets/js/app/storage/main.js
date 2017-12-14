export default {
    namespaced: true,
    state: {
        currentPopup: null,
        autosavedPageData: {
            content: ""
        }
    },
    mutations: {
        savePageData(state, data) {
            state.autosavedPageData = data
        }
    },
    getters: {
        pageData(state) {
            return state.autosavedPageData
        }
    }
}