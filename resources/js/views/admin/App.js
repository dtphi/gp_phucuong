import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSpinner, faEdit, faPlus } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faSpinner, faEdit, faPlus);
Vue.config.productionTip = false;

Vue.component('font-awesome-icon', FontAwesomeIcon);