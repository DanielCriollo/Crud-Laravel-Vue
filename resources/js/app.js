

require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('articulo', require('./components/Articulo.vue').default);


const app = new Vue({
    el: '#app',
});
