require('./app/bootstrap');

import Vue from 'vue'
import Index from './login/Login.vue'

const app = new Vue({
    el: "#login",
    template: "<Index/>",
    components: { Index },
});