import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSpinner, faEdit, faPlus, faUser, faCopy, faBars, faSearch, faTimes } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faSpinner, faEdit, faPlus, faUser, faCopy, faBars, faSearch, faTimes);
Vue.config.productionTip = false;
Vue.component('font-awesome-icon', FontAwesomeIcon);

import { ValidationObserver, ValidationProvider } from 'vee-validate';
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);

import LoadingOverLay from 'vue-loading-overlay';
Vue.component('LoadingOverLay', LoadingOverLay);

import utilMixin from '../../mixins/util';
Vue.mixin(utilMixin);