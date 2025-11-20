import { createApp } from 'vue';
import App from './components/App.vue';
import Apercu from './components/Apercu.vue'; 

import 'select2/dist/css/select2.min.css';
import 'select2';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
window.toastr = toastr;
  

if (document.querySelector('#app')) {
    createApp(App).mount('#app');
}

if (document.querySelector('#apercu')) {
    createApp(Apercu).mount('#apercu');
}

