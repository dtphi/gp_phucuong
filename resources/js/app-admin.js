require('./bootstrap')
const envBuild = process.env.NODE_ENV
import {
  config,
} from './common/config'
window.Pusher = {}// require('pusher-js');

import Vue from 'vue'
import store from 'store@admin'
import Router from 'vue-router'
import routes from './routes/admin'

Vue.use(Router)
window.vue = Vue
require('./views/admin/App')

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
      
      return
    } else {
      if (envBuild === 'production') {
        if (store.state.auth.linhMucExpectSignIn) {
          if (to.name === config.adminRoute.phone_verify.name) {
            window.location.href = store.state.auth.redirectUrl
            
            return
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

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
/*
import Echo from 'laravel-echo'
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                axios.post('/api/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                })
                .then(response => {
                    callback(false, response.data);
                })
                .catch(error => {
                    callback(true, error);
                });
            }
        };
    },
})
*/

if (envBuild == 'development') {
  console.log('ENV:', envBuild)
  console.log('STORE:', store)
  console.log('ROUTE:', routes)
}

if (envBuild === 'production') {
  var loginUriMap = process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN
  var pathLoginArray = []
  var pathDashboardArray = []
  if (loginUriMap) {
    var pathArray = loginUriMap.split(',')
    pathDashboardArray.push(config.slashDir + pathArray[0] + config.slashDir + config.adminRoute.dashboard.path)
    pathDashboardArray.push(config.slashDir + pathArray[0] + config.slashDir + config.adminRoute.dashboard.path + config.slashDir)
            
    // Display array values on page
    for(var i = 0; i < pathArray.length; i++) {
      pathLoginArray.push(config.slashDir + pathArray[i])
      pathLoginArray.push(config.slashDir + pathArray[i] + config.slashDir)
    }
  }
  if (pathLoginArray.length === 0) {
    window.axios.interceptors.response.use(function(response) {
      if(_.includes([403], response.data.code) && !(_.includes(pathDashboardArray, window.location.pathname))) {
        window.location.href = window.location.origin
        
        return Promise.reject(response.data.message)
      }
      
      return response
    }, function(error) {
      if (error.response) {
        if((_.includes([401, 419], error.response.status)) 
                        && !(_.includes(pathLoginArray, window.location.pathname))) {
          window.location.reload()
        }
        if(_.includes([403, 500], error.response.status)) {
          window.location.href = window.location.origin
          
          return Promise.reject(error.response)
        }
      }
    })
  }
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