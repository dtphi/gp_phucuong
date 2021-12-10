import { getAuth, onAuthStateChanged } from 'firebase/auth'
import { initializeApp } from 'firebase/app'

const config = {
  apiKey: 'AIzaSyBKsiV4xyEV3CBbgc1lQh4HATdFkBeRMcM',
  authDomain: 'linhmucgiaophan-phucuong.firebaseapp.com',
  projectId: 'linhmucgiaophan-phucuong',
  storageBucket: 'linhmucgiaophan-phucuong.appspot.com',
  messagingSenderId: '1040600271080',
  appId: '1:1040600271080:web:01f9b8860c43bd24c7a15d'
}

initializeApp(config)
const auth = getAuth()
// Check user login
export default function ({ redirect }) {
  onAuthStateChanged(auth, (user) => {
    if (!user) {
      redirect('/linhmucadmin')
    }
  })
}
