<template>
    <input class="form-control rcms-login-input" v-bind:type="type" v-bind:aria-describedby="content"
           v-bind:placeholder="titleCase(content)" :value="content.year" @input="$emit('input', $event.target.value)" required>
</template>

<script>
    export default {
        props: ['content', 'type'],
        methods: {
            titleCase: function (str) {
                str = str.toLowerCase().split(' ');
                for (let i = 0; i < str.length; i++) {
                    str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1);
                }
                return str.join(' ');
            }
        }
    }
</script>