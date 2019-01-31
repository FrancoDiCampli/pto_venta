
require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

import swal from 'sweetalert2'
window.swal = swal;

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)
// test porpouse
Vue.component(
    'passport-clients', require('./components/passport/Clients.vue'));

Vue.component(
    'passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));

Vue.component(
    'passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));


let routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue') },
  { path: '/developer', component: require('./components/Dev.vue') },
  { path: '/users', component: require('./components/Users.vue') },
  { path: '/profile', component: require('./components/Profile.vue') }
]

const router = new VueRouter({
	mode: 'history',
  routes // short for `routes: routes`
})

Vue.filter('upText',function(text){
	return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){
	return moment(created).format('DD MMMM YYYY');
});

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast = toast;


const app = new Vue({
    el: '#app',
    router
});
