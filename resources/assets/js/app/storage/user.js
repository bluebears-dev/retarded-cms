export default {
    namespaced: true,
    state: {
        selectedUser: null,
        users: null,
        roles: null,
        updatedUsers: {},
        currentUser: {},
    },
    mutations: {
        select(state, user) {
            state.selectedUser = user;
        },
        store(state, users) {
            state.users = users;
        },
        requestList(state) {
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
        requestRemoval(state, user) {
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
        requestUpdate(state) {
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
        },
        currentUser(state, user) {
            state.currentUser = user
        },
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
        },
        username(state) {
            return state.currentUser.login
        },
        userRole(state) {
            if (state.currentUser.roles)
                return state.currentUser.roles[0].id
        },
        userTheme(state) {
            return state.currentUser.theme
        },
    }
};