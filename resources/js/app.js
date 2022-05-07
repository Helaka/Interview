
require('./bootstrap');

window.Vue = require('vue').default;



Vue.component('temparature', require('./components/Temparature.vue').default);



const app = new Vue({
    el: '#app',
});
