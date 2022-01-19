import { getAuth, onAuthStateChanged } from 'firebase/auth'
import { initializeApp, getApps } from 'firebase/app'
import createPersistedState from 'vuex-persistedstate'

const firebaseConfig = {
  apiKey: process.env.fbApiKey,
  authDomain: process.env.fbAuthDomain,
  projectId: process.env.fbProjectId,
  storageBucket: process.env.fbStorageBucket,
  messagingSenderId: process.env.fbMessagingSenderId,
  appId: process.env.fbAppId
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
    if (!user) {
      redirect(`/linhmucadmin?linhmucId=${linhMucId}`)
    } else {
      const keyItem = 'authen-lm-admin'
      let accountItem = 'normal'
      if (user.uid !== '8wK92awwqcauj8g7ljKsISOdpY82') {
        localStorage.setItem(keyItem, accountItem)
      } else {
        accountItem = 'lmadm'
        localStorage.setItem(keyItem, accountItem)
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
      // Set user to page
      const { uid, email, displayName } = user
      store.commit('auth/setUser', { uid, email, displayName, accountItem })
      // Check access url admin
      if (accountItem === 'normal') {
        if (['linhmucadmin-linhmucuser'].includes(route.name)) {
          redirect(`/linhmucadmin/dashboard?linhmucId=${linhMucId}`)
        }
      }
    }
  })
}
