import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import en from 'vuetify/es5/locale/en';
import de from 'vuetify/es5/locale/de';

Vue.use(Vuetify);

export default new Vuetify({
    lang: {
        locales: { de, en },
        current: process.env.VUE_APP_I18N_LOCALE || 'de',
    },
});
