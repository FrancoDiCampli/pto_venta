
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue') },
  { path: '/users', component: require('./components/Users.vue') },
  { path: '/profile', component: require('./components/Profile.vue') }
]

const router = new VueRouter({
	mode: 'history',
  routes // short for `routes: routes`
})




const app = new Vue({
    el: '#app',
    router
});
