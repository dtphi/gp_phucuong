/**
 * Get the first item that pass the test
 * by second argument function
 *
 * @param {Array} list
 * @param {Function} f
 * @return {*}
 */
export function find(list, f) {
  return list.filter(f)[0]
}
/**
 * Deep copy the given object considering circular structure.
 * This function caches all nested objects and its copies.
 * If it detects circular structure, use cached copy to avoid infinite loop.
 *
 * @param {*} obj
 * @param {Array<Object>} cache
 * @return {*}
 */
export function deepCopy(obj, cache = []) {
  // just return if obj is immutable value
  if (obj === null || typeof obj !== 'object') {
    return obj
  }
  // if obj is hit, it is in circular structure
  const hit = find(cache, c => c.original === obj)
  if (hit) {
    return hit.copy
  }
  const copy = Array.isArray(obj) ? [] : {}
  // put the copy into cache at first
  // because we want to refer it in recursive deepCopy
  cache.push({
    original: obj,
    copy,
  })
  Object.keys(obj).forEach(key => {
    copy[key] = deepCopy(obj[key], cache)
  })
  
  return copy
}
/**
 * forEach for object
 */
export function forEachValue(obj, fn) {
  Object.keys(obj).forEach(key => fn(obj[key], key))
}
export function isObject(obj) {
  return obj !== null && typeof obj === 'object'
}
export function isPromise(val) {
  return val && typeof val.then === 'function'
}
export function assert(condition, msg) {
  if (!condition) throw new Error(`[vuex] ${msg}`)
}
export function partial(fn, arg) {
  return function() {
    return fn(arg)
  }
}
export function fnIsObject(obj) {
  if (typeof obj !== 'undefined' &&
    typeof obj === 'object' &&
    Object.keys(obj).length) {
    return true
  }
  
  return false
}
export function fnCheckProp(obj, prop) {
  return Object.prototype.hasOwnProperty.call(obj, prop)
}
export function fnCheckImgSelect(file) {
  const selected = file?.selected
  const isType = typeof selected
  return (isType === 'undefined' || selected === null && isType !== 'object' ) ? null: selected
}
export function fnCheckImgPath(file) {
  const path = file?.selected?.path
  const isType = typeof path
  return (isType === 'undefined' || isType !== 'string') ? null: path
}