/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueRouter from 'vue-router'
import IndexSubCategories from "./pages/sub-categories/index"
import DetailsSubCategory from "./pages/sub-categories/sub-category-details"
import CreateSubCategory from "./pages/sub-categories/create-sub-category"
import EditSubCategory from "./pages/sub-categories/edit-sub-category"
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(ElementUI);

Vue.use(VueRouter)
const routes = [
    {path: '/', component: IndexSubCategories},
    {path: '/edit-sub-category/:sub_category', component: EditSubCategory},

    {path: '/create-sub-category', component: CreateSubCategory},

    {path: '/sub-category-details/:sub_category', component: DetailsSubCategory},

]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    routes // short for `routes: routes`
})

const app = new Vue({

    el: '#subCategoryApp',
    router,



});
