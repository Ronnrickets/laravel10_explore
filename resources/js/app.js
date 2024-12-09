import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import 'vuetify/styles'; // Ensure you are importing Vuetify styles
import Router from './router';
import store from './store';
import App from './template/App.vue';
import * as components from 'vuetify/components'; // Import all Vuetify components
import * as directives from 'vuetify/directives'; // Import all Vuetify directives
import '@mdi/font/css/materialdesignicons.css';

const vuetify = createVuetify({
    components,
    directives, 
});

const app = createApp(App);
app.use(store);
app.use(Router);
app.use(vuetify);

app.mount('#app');