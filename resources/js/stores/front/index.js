import Vue from 'vue'
import Vuex from 'vuex'
import giaoxu from './giaoxus'
import linhmuc from './linhmucs'
import home from './homes'
import video from './videos'
import info from './infos'
import subscribe from './subscribes'
import appModule from './modules'
// import createLogger from '../../plugins/logger'
import { GET_INFORMATION_LIST_TO_CATEGORY, } from '@app/stores/front/types/action-types'
import { MODULE_INFO, } from '@app/stores/front/types/module-types'
const debug = process.env.NODE_ENV === 'debuger'
import { apiGetSettings, } from '@app/api/front/apps'
import { fnIsObject, fnCheckProp, } from '@app/common/util'
Vue.use(Vuex)
const defaultState = () => {
  return {
    logo: '/front/img/logo.png',
    banner: '/Image/NewPicture/home_banners/banner_image.png',
    iconBookUrl: '/',
    navMainLists: [],
    pageLists: [],
    appLists: [],
    infoLasteds: [],
    infoPopulars: [],
    pages: {},
  }
}
const initPaginationState = () => {
  return {
    links: {},
    meta: {},
    perPage: 20,
    moduleActive: {
      name: MODULE_INFO,
      actionList: GET_INFORMATION_LIST_TO_CATEGORY,
      params: {},
    },
    collectionData: {
      current_page: 1,
      from: 0,
      to: 0,
      total: 0,
    },
  }
}
export default new Vuex.Store({
  state: {
    cfApp: {
      setting: defaultState(),
    },
    paginationRoot: initPaginationState(),
    errors: [],
    clientsTestimonialsPage: 4,
  },
  getters: {
    cfApp(state) {
      return state.cfApp
    },
    bannerUrl(state) {
      return state.cfApp.setting.banner
    },
    logoUrl(state) {
      return state.cfApp.setting.logo
    },
    navMainLists(state) {
      let menus = { id: 0, newsgroupname: 'Home', children: [], }
      if (fnIsObject(state.cfApp.setting) && fnCheckProp(state.cfApp.setting, 'navMainLists') &&
        Array.isArray(state.cfApp.setting.navMainLists)) {
        menus.children = { ...state.cfApp.setting.navMainLists, }
      }
      
      return menus
    },
    pageLists(state) {
      return state.cfApp.setting.pageLists
    },
    resourcePaginationData(state) {
      return {
        links: state.paginationRoot.links,
        meta: state.paginationRoot.meta,
      }
    },
    collectionPaginationData(state) {
      const colData = { current_page: 1, from: 0, to: 0, total: 0, }
      if (fnIsObject(state.paginationRoot.collectionData)) {
        return state.paginationRoot.collectionData
      }
      
      return colData
    },
    isNotEmptyList(state) {
      if (fnIsObject(state.paginationRoot.meta) && 
        fnCheckProp(state.paginationRoot.meta, 'total')) {
        return (parseInt(state.paginationRoot.meta.total) > 0)
      }
      
      return false
    },
    moduleNameActive(state) {
      let mName = ''
      if (fnIsObject(state.paginationRoot.moduleActive) && 
        fnCheckProp(state.paginationRoot.moduleActive, 'name')) {
        mName = state.paginationRoot.moduleActive.name
      }
      
      return mName
    },
    moduleActionListActive(state) {
      let mAction = ''
      if (fnIsObject(state.paginationRoot.moduleActive) && fnCheckProp(state.paginationRoot.moduleActive, 'actionList')) {
        mAction = state.paginationRoot.moduleActive.actionList
      }
      
      return mAction
    },
    isScreen414(state) {
      return state.clientsTestimonialsPage == 414
    },
    isScreen767(state) {
      return state.clientsTestimonialsPage == 1
    },
    isScreen1200(state) {
      return state.clientsTestimonialsPage <= 3
    },
    isScreen960(state) {
      return state.clientsTestimonialsPage <= 2
    },
  },
  mutations: {
    initOptions(state, payload) {
      state.options = payload
    },
    initSetting(state, payload) {
      state.cfApp.setting = payload
    },
    appSetError(state, payload) {
      state.errors = payload
    },
    configApp(state, configs) {
      if (fnIsObject(configs.links)) {
        state.paginationRoot.links = configs.links
      }
      if (fnIsObject(configs.meta)) {
        state.paginationRoot.meta = configs.meta
      }
      if (fnIsObject(configs.moduleActive)) {
        state.paginationRoot.moduleActive = configs.moduleActive
      }
      if (fnIsObject(configs.collectionData)) {
        state.paginationRoot.collectionData = configs.collectionData
      }
    },
  },
  actions: {
    setParams({ commit, }, params) {
      commit('initOptions', params)
    },
    appSettings({ commit, }, options) {
      apiGetSettings((responses) => {
        commit('initSetting', responses)
        commit('appSetError', [])
      }, (errors) => {
        commit('appSetError', errors)
      }, options)
    },
    setConfigApp({ commit, }, configs) {
      const links = (fnCheckProp(configs, 'links')) ? configs.links : undefined
      const meta = (fnCheckProp(configs, 'meta')) ? configs.meta : undefined
      const moduleActive = (fnCheckProp(configs, 'moduleActive')) ? configs.moduleActive : undefined
      let defaultState = initPaginationState()
      if (typeof links !== 'undefined') {
        defaultState.links = links
      }
      if (typeof meta != 'undefined') {
        defaultState.meta = meta
      }
      if (typeof moduleActive != 'undefined') {
        if (fnCheckProp(moduleActive, 'name')) {
          defaultState.moduleActive.name = moduleActive.name
        }
        if (fnCheckProp(moduleActive, 'actionList')) {
          defaultState.moduleActive.actionList = moduleActive.actionList
        }
        if (fnCheckProp(moduleActive, 'params')) {
          defaultState.moduleActive.params = moduleActive.params
        }
      }
      let collectionPg = (fnCheckProp(configs, 'collectionData')) ? configs.collectionData : undefined
      if (collectionPg.length == 0) {
        collectionPg = defaultState.collectionData
      }
      defaultState.collectionData = collectionPg
      commit('configApp', defaultState)
    },
    winWidth({ state, }) {
      var w = window.innerWidth
      state.clientsTestimonialsPage = 4
      if (w < 1200) {
        state.clientsTestimonialsPage = 3
      } 
      if (w < 960) {
        state.clientsTestimonialsPage = 2
      }
      if (w < 769) {
        state.clientsTestimonialsPage = 1
      }
      if (w < 500) {
        state.clientsTestimonialsPage = 414
      }
    },
  },
  modules: {
    linhmuc,
    giaoxu,
    home,
    video,
    info,
    subscribe,
    appModule,
  },
  // strict: debug,
  // plugins: debug ? [createLogger()] : []
})