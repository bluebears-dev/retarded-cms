<template>
    <section class="rcms-adduser-form">
        <form method="POST" action="/api/menu" @submit.prevent="create">
            <div class="form-group">
                <label for="rcms-entry">Entry name</label>
                <input class="form-control rcms-input" v-model="entry" id="rcms-entry" type="text" title="Entry name"
                       name="entry" required>
            </div>
            <div class="form-group">
                <label for="rcms-page">Page</label>
                <div class="rcms-form-dropdown">
                    <select v-model="page" id="rcms-page" class="form-control" name="page" title="Page" required>
                        <option v-for="page in pages" :value="page">{{page}}</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="rcms-button">
                <span>Create entry</span>
            </button>
        </form>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                entry: null,
                page: null,
            }
        },
        computed: {
            token: function () {
                let element = document.querySelector("meta[name=csrf-token]");
                return element.content
            },
            pages: function () {
                let pages = this.$store.getters['pageManagement/pages'];

                if (pages)
                    return pages.map((element) => {
                        return element.name;
                    });
                else
                    return [];
            }
        },
        methods: {
            create: function () {
                axios({
                    method: 'post',
                    url: '/api/menu',
                    data: {
                        entry: this.entry,
                        page: this.page,
                        _token: this.token
                    }
                }).then(response => {
                    this.$router.push({name: 'menu'})
                }).catch(error => {
                    console.log(error)
                })
            },
        },
        created() {
            this.$store.commit('pageManagement/requestList');
        }
    }
</script>