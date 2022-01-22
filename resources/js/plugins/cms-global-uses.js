import Vue from 'vue'
import VModal from 'vue-js-modal'
import Notifications from 'vue-notification'

Vue.config.productionTip = false
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