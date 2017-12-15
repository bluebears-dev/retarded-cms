<template>
    <table class="rcms-table rcms-user-table">
            <thead class="rcms-table-header">
            <tr class="rcms-row">
                <td class="rcms-cell">Selected</td>
                <td class="rcms-cell">Username</td>
                <td class="rcms-cell">Role</td>
                <td colspan="2" class="rcms-cell">Actions</td>
            </tr>
        </thead>
        <transition-group name="fade" tag="tbody" class="rcms-table-body">
            <tr v-for="user in users" :key="user.login + user.id" class="rcms-row">
                <td class="rcms-cell">
                    <input
                            :click="selectUser(user)"
                            class="rcms-select"
                            type="radio"
                            name="selected"
                            :id="user.login + user.id" :value="user.id"
                            title="Select user">
                    <label :for="user.login + user.id"></label>
                </td>
                <td class="rcms-cell">
                    <div class="rcms-data">{{user.login}}</div>
                </td>
                <td class="rcms-cell">
                    <div class="rcms-data">
                        <div v-if="canModify" class="rcms-form-dropdown">
                            <select class="form-control" :id="'select_' + user.id" name="role" title="Change role" v-on:click="queueToUpdate(user)">
                                <option v-for="role in roles" :value="role.name" :selected="role.name === user.roles[0].name">{{role.name}}</option>
                            </select>
                        </div>
                        <span v-else>{{user.roles[0].name}}</span>
                    </div>
                </td>
                <td class="rcms-cell">
                    <a v-if="canModify" v-on:click="removeUser(user.id)" class="rcms-button">
                        <span class="fa fa-remove"></span>
                    </a>
                </td>
            </tr>
        </transition-group>
        <tfoot class="rcms-table-footer">
            <tr class="rcms-row">
                <td colspan="5" class="rcms-cell">
                    <router-link :to="{ name: 'addUserView'}" class="rcms-button"><span class="fa fa-plus"></span></router-link>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
    export default {
        computed: {
            users: function () {
                return this.$store.getters['userManagement/users'];
            },
            roles: function () {
                return this.$store.getters['userManagement/roles'];
            },
            canModify: function () {
                return this.$store.getters['userManagement/userRole'] === 1;
            }
        },
        methods: {
            selectUser: function (user) {
                this.$store.commit('userManagement/select', user);
            },
            removeUser: function (user) {
                this.$store.commit('userManagement/requestRemoval', user);
            },
            queueToUpdate: function (user) {
                let newRole = $("#select_" + user.id + " :selected").val();
                if (newRole !== user.roles[0].name)
                    this.$store.commit('userManagement/stageChange', [user, newRole]);
                else
                    this.$store.commit('userManagement/unstageChange', user);
            }
        },
        created () {
            this.$store.commit('userManagement/requestList');
        }
    };
</script>