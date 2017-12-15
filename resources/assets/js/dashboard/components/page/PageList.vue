<template>
    <table class="rcms-table rcms-page-table">
        <thead class="rcms-table-header">
        <tr class="rcms-row">
            <td class="rcms-cell">Name</td>
            <td class="rcms-cell">Parent page</td>
            <td class="rcms-cell">Published</td>
            <td class="rcms-cell">Template</td>
            <td colspan="3" class="rcms-cell">Actions</td>
        </tr>
        </thead>
        <transition-group name="fade" tag="tbody" class="rcms-table-body">
            <tr v-for="page in pages" :key="page.name" class="rcms-row">
                <td class="rcms-cell">
                    {{ page.name }}
                </td>
                <td class="rcms-cell">
                    {{ page.parent_page }}
                </td>
                <td class="rcms-cell">
                    {{ page.active ? "Yes" : "No"}}
                </td>
                <td class="rcms-cell">
                    {{ page.template }}
                </td>
                <td class="rcms-cell">
                    <a :title="page.active ? 'Unpublish page' : 'Publish page'" class="rcms-button">
                        <span class="fa" :class="page.active ? 'fa-eye-slash' : 'fa-eye'"></span>
                    </a>
                </td>
                <td class="rcms-cell">
                    <a title="Edit page" class="rcms-button">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
                <td class="rcms-cell">
                    <a title="Remove page" class="rcms-button">
                        <span class="fa fa-remove"></span>
                    </a>
                </td>
            </tr>
        </transition-group>
        <tfoot class="rcms-table-footer">
        <tr class="rcms-row">
            <td colspan="7" class="rcms-cell">
                <router-link :to="{ name: 'addPage'}" class="rcms-button"><span class="fa fa-plus"></span></router-link>
            </td>
        </tr>
        </tfoot>
    </table>
</template>

<script>
    export default {
        computed: {
            pages: function () {
                return this.$store.getters['pageManagement/pages'];
            },
        },
        // methods: {
        //     selectUser: function (user) {
        //         this.$store.commit('userManagement/select', user);
        //     },
        //     removeUser: function (user) {
        //         this.$store.commit('userManagement/requestUserRemoval', user);
        //     },
        //     queueToUpdate: function (user) {
        //         let newRole = $("#select_" + user.id + " :selected").val();
        //         console.log(newRole);
        //         if (newRole !== user.roles[0].name)
        //             this.$store.commit('userManagement/stageChange', [user, newRole]);
        //         else
        //             this.$store.commit('userManagement/unstageChange', user);
        //     }
        // },
        created () {
            this.$store.commit('pageManagement/requestList');
        }
    };
</script>