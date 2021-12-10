import createPersistedState from 'vuex-persistedstate'

export default ({ store }) => {
  window.onNuxtReady(() => {
    createPersistedState({
      key: 'authen-lm',
      paths: ['auth']
    })(store)
  })
}
