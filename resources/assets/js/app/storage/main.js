export default {
    namespaced: true,
    state: {
        pusher: new Pusher('848b691dd173338e39f8', {
            cluster: 'eu',
            encrypted: true
        })
    },
    getters: {
        pusher(state) {
            return state.pusher
        }
    }
}