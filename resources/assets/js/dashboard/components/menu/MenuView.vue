<template>
    <table class="rcms-table rcms-page-table">
        <thead class="rcms-table-header">
        <tr class="rcms-row">
            <td class="rcms-cell">Entry name</td>
            <td class="rcms-cell">Page</td>
            <td class="rcms-cell">Actions</td>
        </tr>
        </thead>
        <transition-group name="fade" tag="tbody" class="rcms-table-body">
            <tr v-model="menu" v-for="entry in menu" :key="entry.id" class="rcms-row">
                <td class="rcms-cell">
                    {{ entry.entry }}
                </td>
                <td class="rcms-cell">
                    {{ entry.page }}
                </td>
                <td class="rcms-cell">
                    <a v-on:click="remove(entry.id)" title="Remove entry" class="rcms-button">
                        <span class="fa fa-remove"></span>
                    </a>
                </td>
            </tr>
        </transition-group>
        <tfoot class="rcms-table-footer">
        <tr class="rcms-row">
            <td colspan="3" class="rcms-cell">
                <router-link :to="{ name: 'addEntry'}" class="rcms-button"><span class="fa fa-plus"></span></router-link>
            </td>
        </tr>
        </tfoot>
    </table>
</template>

<script>
    export default {
        computed: {
            menu: function () {
                return this.$store.getters['menuManagement/menu'];
            },
        },
        methods: {
            remove(id) {
                this.$store.commit('menuManagement/requestRemoval', id);
            }
        },
        created() {
            this.$store.commit('menuManagement/requestEntries');
        }
    };
</script>