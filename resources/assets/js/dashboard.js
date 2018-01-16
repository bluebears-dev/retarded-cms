import routes from "./app/routes/user";

require('./app/bootstrap');

// Initialize Vue.js
import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

Vue.use(Vuex);
Vue.use(VueRouter);

// Root component
import Dashboard from './dashboard/Dashboard.vue'

// App modules
import store_module from "./app/store";
import router_module from "./app/router";

let store = new Vuex.Store({
    modules: store_module,
});

let router = new VueRouter({
    routes: router_module,
});

router.beforeEach((to, from, next) => {
    let view = document.getElementById('content');
    if (view)
        view.scrollTop = 0;
    next();
});

const app = new Vue({
    el: "#app",
    store,
    router,
    template: "<Dashboard/>",
    components: {Dashboard},
});