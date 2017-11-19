<template>
    <section>
        <form method="POST" @submit.prevent="$emit('edit-user', '')">
            <div class="form-group">
                <input id="new-password" placeholder="New password" name="new-password" type="password">
                <small v-if="'new_equals_old' in this.$data">{{ new_equals_old }}</small>
            </div>
            <hr>
            <div class="form-group">
                <input id="old-password" placeholder="Old password" name="old-password" type="password">
            </div>
            <div class="form-group">
                <input id="repeat-password" placeholder="Repeat password" name="repeat-password" type="password">
            </div>
        </form>
    </section>
</template>

<script>
    export default {
        data: function () {
            return window.store.errors.form;
        }
    }
</script>