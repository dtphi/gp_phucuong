import Vue from 'vue'
import AppConfig from '@app/api/admin/constants/app-config'
import clonedeep from 'lodash/cloneDeep'
import { config, } from '@app/common/config'

/**
* Global prototype vuejs
*/
const helper = {
  slugify: (text, separator = "-") => {
    return text
      .toString()
      .normalize('NFD')                   // split an accented letter in the base letter and the acent
      .replace(/[\u0300-\u036f]/g, '')   // remove all previously split accents
      .toLowerCase()
      .replace(/[^a-z0-9 -]/g, '')   // remove all chars not letters, numbers and spaces (to be replaced)
      .trim()
      .replace(/\s+/g, separator);
  },
  fn_format_dd_mm_yyyy: (date) => {
    if (date === 'Chưa cập nhật' || !date) {
      return ''
    }
    if (date && moment(date).isValid()) {
      return moment(date).format(AppConfig.formatDateString)
    }
    
    return ''
  },
  fn_split_date_time: (strDate) => {
    if (strDate.length) {
      return _.split(strDate, '-')
    }
  },
}

/**
* Global filter vuejs
*/
Vue.filter('capitalize', function(value) {
  if (!value) return ''
  value = value.toString()
  
  return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.prototype.$cmsCfg = config
Vue.prototype.$deep = clonedeep
Vue.prototype.$helper = helper