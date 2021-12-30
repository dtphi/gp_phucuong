import Vue from 'vue'
import clonedeep from 'lodash/cloneDeep'

/**
 * Global prototype vuejs
 */
Vue.prototype.$deep = clonedeep

/**
 * Global filter vuejs
 */
Vue.filter('capitalize', function(value) {
  if (!value) return ''
  value = value.toString()
  
  return value.charAt(0).toUpperCase() + value.slice(1)
})