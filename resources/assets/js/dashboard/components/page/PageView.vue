<template>
    <table class="rcms-table rcms-page-table">
        <thead class="rcms-table-header">
        <tr class="rcms-row">
            <td class="rcms-cell">Name</td>
            <td class="rcms-cell">Route</td>
            <td class="rcms-cell">Published</td>
            <td class="rcms-cell">Template</td>
            <td colspan="3" class="rcms-cell">Actions</td>
        </tr>
        </thead>
        <transition-group name="fade" tag="tbody" class="rcms-table-body">
        <tr v-model="pages" v-for="page in pages" :key="page.name" class="rcms-row">
            <td class="rcms-cell">
                {{ page.name }}
            </td>
            <td class="rcms-cell">
                {{ page.route }}
            </td>
            <td class="rcms-cell">
                <a v-if="show(page.name)" v-on:click="togglePublishedState(page.name)" :title="page.published ? 'Unpublish page' : 'Publish page'" class="rcms-button">
                    <span class="fa" :class="page.published ? 'fa-eye' : 'fa-eye-slash'"></span>
                </a>
                <a v-else :title="page.published ? 'Unpublish page' : 'Publish page'" class="rcms-button rcms-disabled">
                    <span class="fa" :class="page.published ? 'fa-eye' : 'fa-eye-slash'"></span>
                </a>
            </td>
            <td class="rcms-cell">
                {{ page.template }}
            </td>
            <td class="rcms-cell">
                <router-link :to="{ name: 'editPage', params: { page: page.name }}" title="Edit page" class="rcms-button"><span class="fa fa-pencil"></span></router-link>
            </td>
            <td class="rcms-cell">
                <a v-on:click="remove(page.name)" title="Remove page" class="rcms-button">
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
        methods: {
            togglePublishedState(name) {
                this.$store.commit('pageManagement/requestTogglingPublishedState', name);
            },
            show(name) {
                return this.$store.getters['userManagement/currentUserRole'] <= 3 && (name !== 'home');
            },
            remove(name) {
                this.$store.commit('pageManagement/requestRemoval', name);
            }
        },
        created() {
            this.$store.commit('pageManagement/requestList');
        }
    };
</script>