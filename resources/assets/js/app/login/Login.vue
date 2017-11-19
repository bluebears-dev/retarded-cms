<template>
    <form method="POST" v-bind:action="post_url" @submit.prevent="post">
        <div class="form-group">
            <form-input content="login" v-model="login"></form-input>
        </div>
        <div class="form-group">
            <form-input content="password" type="password" v-model="password"></form-input>
        </div>
        <div class="rcms-error-field">
            <small v-for="error in errors">{{ error.join(' ') }}</small>
        </div>
        <button type="submit" class="rcms-login-button">
            <span>Enter</span>
        </button>
    </form>
</template>

<script>
    import FormInput from './components/FormInput.vue'

    export default {
        components: {
            FormInput
        },
        data: function () {
            return {
                'login': '',
                'password': '',
                'post_url': '/login',
                'errors': []
            }
        },
        watch: {},
        computed: {
            token: function () {
                let element = document.querySelector("meta[name=csrf-token]");
                return element.content
            }
        },
        methods: {
            post: function () {
                axios({
                    method: 'post',
                    url: '/login',
                    data: {
                        login: this.login,
                        password: this.password,
                        _token: this.token
                    }
                }).then(response => {
                    if ('redirect' in response.data)
                        window.location.replace(response.data.redirect.match(/\w\/{1}(.*)/)[1]); // redirect to relative url
                }).catch(error => {
                    if ('exception' in error.response.data) {
                        this.$data.errors = {error: ["Unexpected error"]};
                        console.error(error.response.data);
                    } else
                        this.$data.errors = error.response.data
                })
            },
        }
    };
</script>