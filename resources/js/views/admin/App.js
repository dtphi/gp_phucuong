import Vue from 'vue'
import '@app/plugins/cms-filter'
import '@app/plugins/cms-components'
import VModal from 'vue-js-modal'
import Notifications from 'vue-notification'
import moment from 'moment'
import utilMixin from '@app/mixins/admin'

window.moment = moment
window.moment.locale('vi')
Vue.config.productionTip = false
/*Add mixin global*/
Vue.mixin(utilMixin)
/*Add vue js modal and dialog*/
Vue.use(VModal, {
  dialog: true,
  dynamic: true,
  dynamicDefaults: {
    clickToClose: false,
  },
})
/*Add vue notification*/
Vue.use(Notifications)