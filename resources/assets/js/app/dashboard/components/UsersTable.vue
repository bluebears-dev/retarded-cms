<template>
    <table class="rcms-table">
        <thead>
            <tr>
                <td>Selected</td>
                <td>Username</td>
                <td>Role</td>
                <td colspan="2">Actions</td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users">
                <td><input class="rcms-select" type="radio" name="selected" :value="user.id"></td>
                <td><div class="rcms-data">{{user.login}}</div></td>
                <td><div class="rcms-data">{{user.roles[0].name}}</div></td>
                <td><a class="rcms-button">E</a></td>
                <td><a class="rcms-button">R</a></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
    import Popup from './Popup.vue';
    import DeleteMessage from './DeleteMessage.vue';
    import EditMessage from './EditMessage.vue';

    export default {
        components: {
            Popup, DeleteMessage, EditMessage
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
                let old_pass = $('#old-password').val(),
                    new_pass = $('#new-password').val(),
                    repeat_pass = $('#repeat-password').val();
                if (old_pass !== repeat_pass) {

                } else if (new_pass === old_pass) {
                    window.store.errors.form['new_equals_old'] = "New password is the same as old"
                } else {
                    axios({
                        method: 'put',
                        url: '/api/user/' + user,
                        data: {
                            new_password: $('#new-password').val(),
                            old_password: $('#old-password').val()
                        }
                    }).then(response => {
                        console.log(response);
                        $('#edit-user').modal('toggle');
                    }).catch(error => {
                        console.log(error);
                    })
                }
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
                    $('#delete-user').modal('toggle');
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
        }
    };
</script>