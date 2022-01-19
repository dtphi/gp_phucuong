import dotenv from 'dotenv'
dotenv.config()
const fbApiKey = process.env.FB_API_KEY
const fbAuthDomain = process.env.FB_AUTH_DOMAIN
const fbProjectId = process.env.FB_PROJECT_ID
const fbStorageBucket = process.env.FB_STORAGE_BUCKET
const fbMessagingSenderId = process.env.FP_MESSAGING_SENDER_ID
const fbAppId = process.env.FB_APP_ID

let baseUrl = process.env.BASE_URR
let appMiddle = process.env.APP_API_NAME_KEY
let firebasephoneMiddle = process.env.APP_API_FIREBASE_PHONE_NAME_KEY
let apiBaseUrl = `${baseUrl}/api/linhmucadmin`
if (process.env.APP_ENV !== 'production') {
  baseUrl = 'http://localhost:8000'
  apiBaseUrl = `${baseUrl}/api/linhmucadmin`
}

import colors from 'vuetify/es5/util/colors'
// https://eslint.vuejs.org/rules/no-v-html.html
export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s - Linh Mục Admin',
    title: 'Linh Mục Giáo Phận',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'shortcut icon', href: '/images/icons/favicon-33x33.png' },
      { rel: 'icon', type: 'image/x-icon', href: '/images/icons/favicon.png' },
      { rel: 'apple-touch-icon-precomposed', type: 'image/x-icon', href: '/images/icons/favicon-144x144.png' },
      { rel: 'apple-touch-icon-precomposed', type: 'image/x-icon', href: '/images/icons/favicon-114x114.png' },
      { rel: 'apple-touch-icon-precomposed', type: 'image/x-icon', href: '/images/icons/favicon-72x72.png' },
      { rel: 'apple-touch-icon-precomposed', type: 'image/x-icon', href: '/images/icons/favicon-57x57.png' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '@/plugins/local-storage.js'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    'nuxt-history-state'
  ],

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL: apiBaseUrl,
    timeout: 60000,
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
    }
  },

  // set options (see below section)
  historyState: {
    maxHistoryLength: 1, // or any positive integer
    reloadable: true, // or false
    overrideDefaultScrollBehavior: false, // or true
    scrollingElements: '#scroll' // or any selector
  },

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: true,
      themes: {
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    publicPath: '/administrator/linhmucadmin-js'
  },

  env: {
    appMiddle,
    firebasephoneMiddle,
    baseUrl,
    apiBaseUrl,
    fbApiKey,
    fbAuthDomain,
    fbProjectId,
    fbStorageBucket,
    fbMessagingSenderId,
    fbAppId
  },

  generate: {
    exclude: [
      /^\/linhmucadmin/
    ],
    fallback: true
  }
}
