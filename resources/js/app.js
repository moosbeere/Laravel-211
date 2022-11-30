require('./bootstrap');
import {createApp} from 'vue'
import App from './components/ExampleComponent.vue'

const app=createApp({})
app.component('App', App)

app.mount('#app')
