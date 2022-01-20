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

Vue.component('CustomComponent', CustomComponent);

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

new Vue({
    router,
    store,
    i18n,
    vuetify,
    admin,
    render: (h) => h(App),
}).$mount('#app');
