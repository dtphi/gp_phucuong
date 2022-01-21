require('./bootstrap')
import {
  config,
} from './common/config'
import Vue from 'vue'
import store from 'store@admin'
import Router from 'vue-router'
import routes from '@app/routes/admin'
require('./views/admin/App')

Vue.use(Router)

const envBuild = process.env.NODE_ENV

const router = new Router({
  history: config.adminRoute.history,
  mode: config.adminRoute.mode,
  routes: [
    ...routes
  ],
})

router.beforeEach(async(to, from, next) => {
  document.title = to.meta.title
  if (store.state.auth.authenticated) {
    if (to.name === config.adminRoute.login.name) {
      window.location.href = store.state.auth.redirectUrl
    } else {
      if (envBuild === 'production') {
        if (store.state.auth.linhMucExpectSignIn) {
          if (to.name === config.adminRoute.phone_verify.name) {
            window.location.href = store.state.auth.redirectUrl
          } else {
            next()
            
            return
          }
        } else {
          if (to.name === config.adminRoute.phone_verify.name) {
            next()
            
            return
          }
          window.location.href = store.state.auth.redirectPhoneLoginUrl
        }
      } else {
        next()
        
        return
      }
    }
  } else {
    if (to.name === config.adminRoute.login.name) {
      next()
      
      return
    }
    window.location.href = store.state.auth.redirectLogoutUrl
  }

  next()
})

if (envBuild === 'production') {
  require('./middleware/redirect-authentication')
}

store.dispatch('auth/admin', {
  type: 'init',
}).then(() => {
  return new Vue({
    el: '#gp-phu-cuong',
    router,
    store,
  })
})