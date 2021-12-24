import Vue from 'vue'
// font.awsome.icon
require('./assets/font.awsome.icon')
/* Add BootstrapVue */
import 'bootstrap/dist/css/bootstrap.css'
import {
  BootstrapVue,
  BootstrapVueIcons
} from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
import VueLazyload from 'vue-lazyload'
// import loadingLazy from '@app/views/front/assets/loading/fading-loading-lazy_30.svg'
/* Add vue lazyload */
Vue.use(VueLazyload, {
  // error: loadingLazy,
  // loading: loadingLazy,
  attempt: 1,
})
Vue.config.productionTip = false
/* Add vue loading overplay */
/* import LoadingOverLay from 'vue-loading-overlay'
 import 'vue-loading-overlay/dist/vue-loading.css'
 Vue.component('LoadingOverLay', LoadingOverLay)
*/
/* Add mixin global */
import utilMixin from '@app/mixins/front'
Vue.mixin(utilMixin)