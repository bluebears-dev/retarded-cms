<template>
    <div id="login" class="container-fluid rcms-login-background">
        <div class="rcms-form-wrapper">
            <form-title v-bind:title="title"></form-title>
            <form method="POST" v-bind:action="post_url" @submit.prevent="post">
                <div class="form-group">
                    <form-input content="login" v-model="login"></form-input>
                </div>
                <div class="form-group">
                    <form-input content="password" type="password" v-model="password"></form-input>
                </div>
                <div class="rcms-form-error-field">
                    <small v-for="error in errors" class="rcms-error">{{ error.join(' ') }}</small>
                </div>
                <button type="submit" class="btn rcms-login-button">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
    import FormInput from './components/FormInput.vue'
    import FormTitle from './components/FormTitle.vue'

    export default {
        components: {
            FormTitle, FormInput
        },
        data: function () {
            return {
                'title': 'rCMS Login',
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