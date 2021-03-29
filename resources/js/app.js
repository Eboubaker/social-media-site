
require('./bootstrap.js');
require('./scroll-view');
// require('./int-tel-input');

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
//
import Vue from 'vue';
import VueResource from 'vue-resource';

// tell Vue to use the vue-resource plugin
Vue.use(VueResource);

// import FormError component
// import FormError from './components/FormError.vue';
window.Vue = Vue;
// import VueRouter from 'vue-router';
// import routes from './routes';
// Vue.use(VueRouter);

// const app = new Vue({
//     el: '#app',
//     router: new VueRouter(routes)
// });
