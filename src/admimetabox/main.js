import Vue from 'vue'
import App from './App.vue'
import store from "./store";
import vuetify from '../plugins/vuetify'



Vue.config.productionTip = false

new Vue({
    el: '#vue-metaboxes-app',
    vuetify,
    store,
    render: h => h(App),

})
