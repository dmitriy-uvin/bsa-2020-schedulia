import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#281AC8',
                secondary: '#F9F9F9',
                accent: '#18A0FB',
                error: '#FF3E1D',
                info: '#8B90A0',
                success: '#4CAF50',
                warning: '#FFD67A',
                background: '#F9F9F9',
                validationError: '#FFE9E9',
                eventColor: '#18A0FB',
                lightGrey: '#eae8f9',
                customDark: '#2c2c2c'
            }
        },
        options: {
            customProperties: true
        }
    }
});
