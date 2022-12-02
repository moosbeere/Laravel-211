require('./bootstrap');
import {createApp} from 'vue'
import App from './components/ExampleComponent.vue'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app=createApp({})
app.use(VueSweetalert2);

app.component('App', App)
app.mount('#app')

