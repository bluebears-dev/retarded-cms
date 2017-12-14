<template>
    <div class="rcms-options-entry" v-on:click="changeTheme" :style="getColor(0)">
        <div :style="getColor(4)"></div>
        <div :style="getColor(3)"></div>
        <div :style="getColor(2)"></div>
        <div :style="getColor(1)"></div>
        <div :style="getColor(0)"></div>
        <span>{{name}}</span>
    </div>
</template>

<script>
    export default {
        props: ['name', 'encodedColors'],
        computed: {
            colors() {
                return atob(this.encodedColors).split(';')
            }
        },
        methods: {
            getColor(index) {
                if (index < this.colors.length && index >= 0)
                    return 'background: #' + this.colors[index] + ';';
                else
                    return 'background: transparent;';
            },
            changeTheme() {
                axios({
                    method: 'post',
                    url: '/api/user/theme',
                    data: {
                        name: this.name
                    }
                })
                .then(response => {
                    if (response.status === 200)
                        document.location.reload();
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>