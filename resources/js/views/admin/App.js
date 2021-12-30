import Vue from 'vue'
import '../../plugins/filter'
import moment from 'moment'
window.moment = moment
window.moment.locale('vi')
/*Add fontawesome free*/
import {
  library,
} from '@fortawesome/fontawesome-svg-core'
import {
  faHome,
  faSpinner,
  faEdit,
  faPlus,
  faUser,
  faCopy,
  faInfo,
  faFile,
  faBars,
  faSearch,
  faTimes,
  faCircle,
  faPowerOff,
  faFolder,
} from '@fortawesome/free-solid-svg-icons'
import {
  FontAwesomeIcon,
  FontAwesomeLayers,
  FontAwesomeLayersText,
} from '@fortawesome/vue-fontawesome'
library.add(faHome, faSpinner, faEdit, faPlus, faUser, faCopy, faInfo, faFile, faBars, faSearch, faTimes, faCircle, faPowerOff, faFolder)
Vue.config.productionTip = false
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('font-awesome-layers', FontAwesomeLayers)
Vue.component('font-awesome-layers-text', FontAwesomeLayersText)

/*Add vee validate*/
import {
  ValidationObserver,
  ValidationProvider,
} from 'vee-validate'
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)

/*Add vue loading overplay*/
import LoadingOverLay from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
Vue.component('LoadingOverLay', LoadingOverLay)

/*Add mixin global*/
import utilMixin from '@app/mixins/admin'
Vue.mixin(utilMixin)

/*Add vue js modal and dialog*/
import VModal from 'vue-js-modal'
Vue.use(VModal, {
  dialog: true,
  dynamic: true,
  dynamicDefaults: {
    clickToClose: false,
  },
})

/*Add vue notification*/
import Notifications from 'vue-notification'
Vue.use(Notifications)

import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
Vue.component('CmsDatePicker', DatePicker)