import { getAuth, onAuthStateChanged } from 'firebase/auth'
import { initializeApp, getApps } from 'firebase/app'
import createPersistedState from 'vuex-persistedstate'

const firebaseConfig = {
  apiKey: 'AIzaSyBKsiV4xyEV3CBbgc1lQh4HATdFkBeRMcM',
  authDomain: 'linhmucgiaophan-phucuong.firebaseapp.com',
  projectId: 'linhmucgiaophan-phucuong',
  storageBucket: 'linhmucgiaophan-phucuong.appspot.com',
  messagingSenderId: '1040600271080',
  appId: '1:1040600271080:web:01f9b8860c43bd24c7a15d'
}
const apps = getApps()
if (!apps.length) {
  initializeApp(firebaseConfig)
}

const firebaseAuth = getAuth()
// Check user login
export default function ({ store, route, redirect }) {
  const values = Object.keys(route.query)
  let linhMucId = null
  if (values.includes('linhmucId')) {
    linhMucId = route.query.linhmucId
  }
  onAuthStateChanged(firebaseAuth, (user) => {
    console.log('middleware', user)
    if (!user) {
      redirect(`/linhmucadmin?linhmucId=${linhMucId}`)
    } else {
      const keyItem = 'authen-lm-admin'
      if (user.uid !== '8wK92awwqcauj8g7ljKsISOdpY82') {
        localStorage.setItem(keyItem, 'normal')
      } else {
        localStorage.setItem(keyItem, 'lmadm')
      }
      let authLm = localStorage.getItem('authen-lm')
      if (authLm) {
        authLm = JSON.parse(authLm)

        if (!Object.keys(authLm).length) {
          if (user.uid !== authLm.auth.user.uid) {
            localStorage.removeItem('authen-lm')
            createPersistedState({
              key: 'authen-lm',
              paths: ['auth']
            })(store)
          }
        }
      }
    }
  })
}
