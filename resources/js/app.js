require("./bootstrap");

window.Vue = require("vue");
import moment from "moment";
Vue.prototype.moment = moment;

import { Form, HasError, AlertError } from "vform";

window.Fire = new Vue();

import swal from "sweetalert2";
window.swal = swal;

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import VueRouter from "vue-router";
Vue.use(VueRouter);
// test porpouse
Vue.component("passport-clients", require("./components/passport/Clients.vue"));

Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue")
);

Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue")
);

import VueTheMask from "vue-the-mask";
Vue.use(VueTheMask);

let routes = [
    { path: "/dashboard", component: require("./components/Dashboard.vue") },
    { path: "/developer", component: require("./components/Dev.vue") },
    { path: "/users", component: require("./components/Users.vue") },
    { path: "/profile", component: require("./components/Profile.vue") },
    { path: "/clientes", component: require("./components/Clientes.vue") },
    { path: "/categorias", component: require("./components/Categorias.vue") },
    { path: "/articulos", component: require("./components/Articulos.vue") },
    {
        path: "/inventarios/:id",
        name: "articulo",
        component: require("./components/Inventarios.vue")
    },
    { path: "/suppliers", component: require("./components/Suppliers.vue") },
    { path: "/marcas", component: require("./components/Marcas.vue") },
    { path: "/factura", component: require("./components/Factura.vue") },
    { path: "/remito", component: require("./components/Remito.vue") },
    { path: "/remitos", component: require("./components/Remito.vue") },
    { path: "/compras", component: require("./components/Compras.vue") },
    { path: "/afip", component: require("./components/Afip.vue") },
    { path: "/lista", component: require("./components/Facturas.vue") },
    { path: "/grafico", component: require("./components/graph/Graph.vue") }
];

const router = new VueRouter({
    mode: "history",
    routes // short for `routes: routes`
});

Vue.filter("upText", function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter("myDate", function(created) {
    return moment(created).format("DD MMMM YYYY");
});

const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

Vue.component("pagination", require("laravel-vue-pagination"));

const app = new Vue({
    el: "#app",
    router,

    data: {
        search: ""
    },

    methods: {
        searchit() {
            Fire.$emit("searching");
        }
    }
});
