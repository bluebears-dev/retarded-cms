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
        <transition-group name="fade" tag="tbody">
            <tr v-for="user in users" :key="user.login + user.id">
                <td>
                    <input
                            :click="selectUser(user)"
                            class="rcms-select"
                            type="radio"
                            name="selected"
                            :id="user.login + user.id" :value="user.id"
                            title="Select user">
                    <label :for="user.login + user.id"></label>
                </td>
                <td>
                    <div class="rcms-data">{{user.login}}</div>
                </td>
                <td>
                    <div class="rcms-data">
                        <div v-if="canModify" class="rcms-form-dropdown">
                            <select class="form-control" :id="'select_' + user.id" name="role" title="Change role" v-on:click="queueToUpdate(user)">
                                <option v-for="role in roles" :value="role.name" :selected="role.name === user.roles[0].name">{{role.name}}</option>
                            </select>
                        </div>
                        <span v-else>{{user.roles[0].name}}</span>
                    </div>
                </td>
                <td>
                    <a v-if="canModify" v-on:click="removeUser(user.id)" class="rcms-button">
                        <span class="icon ion-trash-b"></span>
                    </a>
                </td>
            </tr>
        </transition-group>
        <tfoot>
        <tr>
            <td colspan="5"><a class="rcms-button"><span class="icon ion-plus"></span></a></td>
        </tr>
        </tfoot>
    </table>
</template>

<script>
    import Popup from '../Popup.vue';
    import DeleteMessage from '../DeleteMessage.vue';
    import EditMessage from '../EditMessage.vue';

    export default {
        components: {
            Popup, DeleteMessage, EditMessage
        },
        computed: {
            users: function () {
                return this.$store.getters['userManagement/users'];
            },
            roles: function () {
                return this.$store.getters['userManagement/roles'];
            },
            canModify: function () {
                return this.$store.getters.userRole === 1;
            }
        },
        methods: {
            selectUser: function (user) {
                this.$store.commit('userManagement/select', user);
            },
            removeUser: function (user) {
                this.$store.commit('userManagement/requestUserRemoval', user);
            },
            queueToUpdate: function (user) {
                let newRole = $("#select_" + user.id + " :selected").val();
                console.log(newRole);
                if (newRole !== user.roles[0].name)
                    this.$store.commit('userManagement/stageChange', [user, newRole]);
                else
                    this.$store.commit('userManagement/unstageChange', user);
            }
        },
        created () {
            this.$store.commit('userManagement/requestUserList');
        }
    };
</script>