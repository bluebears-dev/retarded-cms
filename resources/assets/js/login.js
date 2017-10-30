require('./bootstrap');

import Vue from 'vue'
import Index from './app/login/Login.vue'


const app = new Vue({
    el: "#login",
    template: "<Index/>",
    components: { Index },
});