<template>
    <nav class="navbar-nav rcms-submenu">
        <a v-if="show()" @click="addUserForm" class="nav-link">
            <div class="fa fa-user-plus"></div>
            <span>New user</span>
        </a>
        <a v-if="show()" @click="removeUser" class="nav-link">
            <div class="fa fa-remove"></div>
            <span>Remove user</span>
        </a>
        <a v-if="show()" @click="saveChanges" class="nav-link">
            <div class="fa fa-check"></div>
            <span>Save</span>
        </a>
    </nav>
</template>

<script>
    export default {
        methods: {
            removeUser: function () {
                let id = $('input[type=radio]:checked', '#content table').val();
                this.$store.commit('userManagement/requestRemoval', id);
            },
            saveChanges: function () {
                this.$store.commit('userManagement/requestUpdate');
            },
            addUserForm: function () {
                this.$router.push({name: 'addUserView'});
            },
            show: function () {
                return this.$store.getters['userManagement/currentUserRole'] === 1;
            }
        }
    }
</script>