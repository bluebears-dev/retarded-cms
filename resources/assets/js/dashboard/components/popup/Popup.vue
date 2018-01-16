<template>
    <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ message }}
                </div>
                <div class="modal-footer">
                    <button v-if="buttons.cancel" v-on:click="actions.cancel" type="button" class="btn btn-secondary" data-dismiss="modal">{{ buttons.cancel }}</button>
                    <button v-if="buttons.ok" v-on:click="actions.ok" type="button" class="btn btn-primary" data-dismiss="modal">{{ buttons.ok }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            title() {
                return this.$store.getters['popup/title'];
            },
            message() {
                return this.$store.getters['popup/message'];
            },
            buttons() {
                return this.$store.getters['popup/buttons'];
            },
            actions() {
                return this.$store.getters['popup/actions'];
            },
        }
    };
</script>