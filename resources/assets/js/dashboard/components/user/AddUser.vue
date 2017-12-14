<template>
    <section class="rcms-adduser-form">
        <form method="POST" action="/api/user" @submit.prevent="create">
            <div class="form-group">
                <label for="rcms-login">Login</label>
                <input class="form-control rcms-input" v-model="login" id="rcms-login" type="text" title="Login" name="Login" required>
            </div>
            <div class="form-group">
                <label for="rcms-password">Password</label>
                <input id="rcms-password" v-model="password" class="form-control rcms-input" type="password" title="Password" name="Password" required>
            </div>
            <div class="form-group">
                <label for="rcms-repeat-password">Repeat password</label>
                <input id="rcms-repeat-password" v-model="repeatedPassword" class="form-control rcms-input" type="password" title="Repeat password" name="Repeat password" required>
            </div>
            <div class="form-group">
                <label for="rcms-role">Role</label>
                <div class="rcms-form-dropdown">
                    <select v-model="role" id="rcms-role" class="form-control" name="role" title="Role" required>
                        <option v-for="role in roles" :value="role.name">{{role.name}}</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="rcms-button">
                <span>Create user</span>
            </button>
        </form>
    </section>
</template>

<script>
    export default {
        data () {
            return {
                login: null,
                password: null,
                repeatedPassword: null,
                role: null
            }
        },
        computed: {
            roles: function () {
                return this.$store.getters['userManagement/roles'];
            },
            token: function () {
                let element = document.querySelector("meta[name=csrf-token]");
                return element.content
            }
        },
        methods: {
            create: function () {
                if (this.password === this.repeatedPassword) {
                    axios({
                        method: 'post',
                        url: '/api/user',
                        data: {
                            login: this.login,
                            password: this.password,
                            role: this.role,
                            _token: this.token
                        }
                    }).then(response => {
                        console.log(response);
                        this.$router.push({ name: 'users'})
                    }).catch(error => {
                        console.log(error)
                    })
                }
            },
        }
    }
</script>