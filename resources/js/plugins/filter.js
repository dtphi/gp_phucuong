import Vue from 'vue'
import clonedeep from 'lodash/cloneDeep'

/**
 * Global prototype vuejs
 */
Vue.prototype.$deep = clonedeep
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
  }
}
Vue.prototype.$helper = helper
/**
 * Global filter vuejs
 */
Vue.filter('capitalize', function(value) {
  if (!value) return ''
  value = value.toString()
  
  return value.charAt(0).toUpperCase() + value.slice(1)
})