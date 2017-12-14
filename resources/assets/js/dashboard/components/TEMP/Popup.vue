<template>
    <div class="modal fade" v-bind:id="id" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div :is="message"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-on:click="$emit(event)" type="button" class="btn btn-primary">{{ button }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DeleteMessage from './DeleteMessage.vue';
    import UserEdit from '../user/AddUser.vue';

    export default {
        components: {
            DeleteMessage, UserEdit
        },
        data: function () {
            return {

            }
        },
        props: ['title', 'message', 'id', 'button', 'event']
    };
</script>