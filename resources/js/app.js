require('./bootstrap');
import Vue from 'vue'

import App from  './view/App.vue'

const app = new Vue({
   el : '#app',
   render : h => h(App)
});

export default app;