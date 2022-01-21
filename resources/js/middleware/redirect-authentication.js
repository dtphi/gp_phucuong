import {
  config,
} from '@app/common/config'

var loginUriMap = process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN
var pathLoginArray = []
var pathDashboardArray = []
if (loginUriMap) {
  var pathArray = loginUriMap.split(',')
  pathDashboardArray.push(`${config.slashDir}${pathArray[0]}${config.slashDir}${config.adminRoute.dashboard.path}`)
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