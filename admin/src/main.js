import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import i18n from './i18n';
import vuetify from './plugins/vuetify';
import admin from './plugins/admin';
import './plugins/i18n';
import './plugins/base';
import './plugins/chartist';
import './sass/overrides.sass';
import CustomComponent from './components/CustomComponent';
import CustomTimePicker from "@/components/CustomTimePicker";
Vue.component('CustomComponent', CustomComponent);
Vue.component('CustomTimePicker', CustomTimePicker);

Vue.config.productionTip = false;

Vue.prototype.$statusColor = (s) => {
    const colors = {
        new: 'error',
        open: 'warning',
        progress: 'primary',
        ready: 'success',
    };

    return colors[s];
};

Vue.prototype.$eventTypeColor = (s) => {
    const colors = {
        Baumpflege : 'brown lighten-1',
        Zaunbau : 'purple',
        Gartenpflege: 'green',
        Transport: 'blue',
        pers_Termin : 'red',
        Winterdienst : 'grey',
        Sonstiges : 'orange',

    };

    return colors[s];
}

new Vue({
    router,
    store,
    i18n,
    vuetify,
    admin,
    render: (h) => h(App),
}).$mount('#app');
