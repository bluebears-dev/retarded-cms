<template>
    <div>
        <ul class="rcms-users-list">
            <li class="rcms-user" v-for="user in users">
                <div class="rcms-username">{{ user.login }}</div>
                <div class="rcms-wrapper">
                    <button class="rcms-role" disabled>{{ user.roles[0].name }}</button>
                    <button v-on:click="editUser(user.id)" v-if="canModify(user.roles[0].name)" title="Edit user"
                            class="rcms-edit">
                        <span class="ion-edit"></span>
                    </button>
                    <button v-on:click="selected_user = user.id" data-toggle="modal" data-target="#deleteUser"
                            v-if="canModify(user.roles[0].name)" title="Remove user" class="rcms-delete">
                        <span class="ion-trash-a"></span>
                    </button>
                </div>
            </li>
        </ul>
        <popup v-on:delete-user="removeUser(selected_user)"
               message="Are you sure you want to delete this user?"
               id="deleteUser"
               title="User removal"
               button="Remove">
        </popup>
        <p v-for="error in errors">{{ error.join(' ') }}</p>
    </div>
</template>

<script>
    import Popup from './Popup.vue';

    export default {
        components: {
            Popup
        },
        data: function () {
            return {
                'users': {},
                'permissions': {},
                'errors': null,
                'hierarchy': {
                    'admin': 1,
                    'moderator': 2,
                    'publisher': 3
                },
                'selected_user': null,
            }
        },
        methods: {
            getUsers: function () {
                axios({
                    method: 'get',
                    url: '/api/user',
                }).then(response => {
                    if ('users' in response.data)
                        this.$data.users = response.data.users;
                    if ('permissions' in response.data)
                        this.$data.permissions = response.data.permissions;
                }).catch(error => {
                    console.log(error)
                    this.$data.errors = error.response.data;
                    this.$data.errors.refresh = ["View will automatically refresh when data is available."];
                })
            },
            editUser: function (user) {
                axios({
                    method: 'get',
                    url: '/api/user/' + user + "/edit",
                }).then(response => {

                }).catch(error => {
                    console.log(error);
                })
            },
            addUser: function (user) {
                axios({
                    method: 'post',
                    url: '/api/user',
                    data: {
                        login: this.login,
                        password: this.password,
                        _token: this.token
                    }
                }).then(response => {

                }).catch(error => {
                    console.log(error);
                })
            },
            removeUser: function (user) {
                axios({
                    method: 'delete',
                    url: '/api/user/' + user,
                }).then(response => {
                    this.$data.users.pop(response.data.id);
                }).catch(error => {
                    console.log(error);
                })
            },
            canModify: function (user_role) {
                return (this.$data.hierarchy[user_role] >= this.$data.hierarchy[window.store.currentUser.role_name()]);
            }
        },
        mounted: function () {
            this.getUsers()
        },
        events: {
            deleteUser: function () {

            }
        }
    };
</script>