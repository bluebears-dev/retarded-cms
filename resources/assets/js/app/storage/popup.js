export default {
    namespaced: true,
    state: {
        title: '',
        message: '',
        buttons: {
            ok: null,
            cancel: null
        },
        actions:  {
            ok: null,
            cancel: null
        },
    },
    actions: {
        initalize({commit}, {title, message, buttons, actions}) {
            commit('setTitle', title);
            commit('setMessage', message);
            commit('setButtons', buttons);
            commit('setActions', actions);
        }
    },
    mutations: {
        setTitle(state, title) {
            state.title = title;
        },
        setMessage(state, message) {
            state.message = message;
        },
        setButtons(state, {ok, cancel}) {
            state.buttons = {
                ok: ok,
                cancel: cancel
            }
        },
        setActions(state, {ok, cancel}) {
            state.actions = {
                ok: ok,
                cancel: cancel
            }
        }
    },
    getters: {
        title(state) {
            return state.title;
        },
        message(state) {
            return state.message;
        },
        buttons(state) {
            return state.buttons;
        },
        actions(state) {
            return state.actions;
        }
    },
};