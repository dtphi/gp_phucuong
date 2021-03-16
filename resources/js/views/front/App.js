import Vue from 'vue';

/*Add fontawesome free*/
import {
  library
} from '@fortawesome/fontawesome-svg-core';
import {
  faSpinner,
  faEdit,
  faPlus,
  faUser,
  faCopy,
  faBars,
  faSearch,
  faTimes,
  faCircle
} from '@fortawesome/free-solid-svg-icons';
import { faFacebook, faYoutube, faGoogle, faTwitter } from '@fortawesome/free-brands-svg-icons';
import {
  FontAwesomeIcon,
  FontAwesomeLayers,
  FontAwesomeLayersText
} from '@fortawesome/vue-fontawesome'
library.add(faSpinner, faEdit, faPlus, faUser, faCopy, faBars, faSearch, faTimes, faCircle, faFacebook, faYoutube, faGoogle, faTwitter);
Vue.config.productionTip = false;
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('font-awesome-layers', FontAwesomeLayers);
Vue.component('font-awesome-layers-text', FontAwesomeLayersText);

/*Add vee validate*/
import {
  ValidationObserver,
  ValidationProvider
} from 'vee-validate';
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);

/*Add vue loading overplay*/
import LoadingOverLay from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.component('LoadingOverLay', LoadingOverLay);

/*Add mixin global*/
import utilMixin from '@app/mixins/front';
Vue.mixin(utilMixin);

/*Add vue js modal and dialog*/
import VModal from 'vue-js-modal';
Vue.use(VModal, {
  dialog: true
});

/* Add BootstrapVue */
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)