

require('./bootstrap');

window.Vue = require('vue').default;
import store from './store/index';
import Vuex from 'vuex'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(Vuex);
Vue.use(ElementUI);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('all-campaigns', require('./components/AllCampaigns.vue').default);
Vue.component('create-campaign', require('./components/CreateCampaign.vue').default);

const app = new Vue({
    store,
    el: '#app',
});