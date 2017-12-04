<template>
    <transition name="fade">
        <nav class="navbar-nav rcms-submenu">
            <a v-if="show()" v-on:click="addUserForm" class="nav-link">
                <div class="icon ion-plus"></div><span>Add</span>
            </a>
            <a v-if="show()" v-on:click="removeUser" class="nav-link">
                <div class="icon ion-trash-b"></div><span>Remove</span>
            </a>
            <a v-if="show()" v-on:click="saveChanges" class="nav-link">
                <div class="icon ion-checkmark"></div><span>Save</span>
            </a>
        </nav>
    </transition>
</template>

<script>
    export default {
        methods: {
            removeUser: function () {
                let id = $('input[type=radio]:checked', '#content table').val();
                this.$store.commit('userManagement/requestUserRemoval', id);
            },
            saveChanges: function () {
                this.$store.commit('userManagement/requestUserUpdate');
            },
            addUserForm: function () {
                this.$router.push({ name: 'addUserView'});
            },
            show: function () {
                return this.$store.getters.userRole === 1;
            }
        }
    }
</script>