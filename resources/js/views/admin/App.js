import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSpinner, faEdit, faPlus, faUser, faCopy, faBars, faSearch, faTimes, faCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon, FontAwesomeLayers, FontAwesomeLayersText } from '@fortawesome/vue-fontawesome'
library.add(faSpinner, faEdit, faPlus, faUser, faCopy, faBars, faSearch, faTimes, faCircle);
Vue.config.productionTip = false;
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('font-awesome-layers', FontAwesomeLayers);
Vue.component('font-awesome-layers-text', FontAwesomeLayersText);

import { ValidationObserver, ValidationProvider } from 'vee-validate';
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);

import LoadingOverLay from 'vue-loading-overlay';
Vue.component('LoadingOverLay', LoadingOverLay);

import utilMixin from '../../mixins';
Vue.mixin(utilMixin);

import VModal from 'vue-js-modal';
Vue.use(VModal, { dialog: true });