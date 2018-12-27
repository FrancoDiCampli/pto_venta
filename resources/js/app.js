
require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

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

Vue.filter('upText',function(text){
	return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){
	return moment(created).format('DD MMMM YYYY');
});


const app = new Vue({
    el: '#app',
    router
});
