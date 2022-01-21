import Vue from 'vue'
import {
  ValidationObserver,
  ValidationProvider,
} from 'vee-validate'
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
import LoadingOverLay from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
import { ToggleButton } from 'vue-js-toggle-button'

/*Add fontawesome free*/
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('font-awesome-layers', FontAwesomeLayers)
Vue.component('font-awesome-layers-text', FontAwesomeLayersText)
/*Add vee validate*/
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)
/*Add vue loading overplay*/
Vue.component('LoadingOverLay', LoadingOverLay)
Vue.component('CmsDatePicker', DatePicker)
Vue.component('ToggleButton', ToggleButton)