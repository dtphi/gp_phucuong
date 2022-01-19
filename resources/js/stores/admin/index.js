import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import layout from './layout'
import dashboard from './dashboad'
import user from './users'
import info from './infos'
import news_category from './categories'
import app_module from './modules'
import linh_muc from './linhmucs'
import bang_cap from './linhmucbangcaps'
import chuc_thanh from './linhmucchucthanhs'
import van_thu from './linhmucvanthus'
import thuyen_chuyen from './linhmucthuyenchuyens'
import giao_phan from './giaophans'
import giao_hat from './giaohats'
import giao_xu from './giaoxus'
import giao_diem from './giaodiems'
import cong_doan_tu_si from './congdoantusis'
import dong from './dongs'
import co_so from './cosos'
import ban_chuyen_trach from './banchuyentrachs'
import thanh from './thanhs'
import chuc_vu from './chucvus'
import le_chinh from './lechinhs'
import restrict_ip from './restrictips'
import albums from './albums'
import ngay_le from './ngayles'
import group_albums from './groupalbums'
import danhmuc_giaophan from './giaophandanhmucs'
import tintuc_giaophan from './giaophantintucs'
import createLogger from '../../plugins/logger'
import { fnCheckProp, } from '@app/common/util'

Vue.use(Vuex)

const debug = 'debuger, development'.includes(process.env.NODE_ENV)

const fnIsObject = (obj) => {
  if (typeof obj !== 'undefined' &&
    typeof obj === 'object' &&
    Object.keys(obj).length) {
    return true
  }

  return false
}

const defaultState = () => {
  return {
    errors: [],
    links: {},
    meta: {},
    perPage: 15,
    moduleActive: {
      name: '',
      actionList: '',
    },
    logo: '/front/img/logo.png',
    collectionData: {
      current_page: 1,
      from: 0,
      to: 0,
      total: 0,
    },
    searchs: {}
  }
}

export default new Vuex.Store({
  state: {
    cfApp: defaultState(),
  },
  getters: {
    resourcePaginationData(state) {
      return {
        links: state.cfApp.links,
        meta: state.cfApp.meta,
      }
    },
    collectionPaginationData(state) {
      const colData = {
        current_page: 1,
        from: 0,
        to: 0,
        total: 0,
      }
      if (fnIsObject(state.cfApp.collectionData)) {
        return state.cfApp.collectionData
      }

      return colData
    },
    isNotEmptyList(state) {
      if (fnIsObject(state.cfApp.meta) &&
        fnCheckProp(state.cfApp.meta, 'total')) {
        return (parseInt(state.cfApp.meta.total) > 0)
      }

      return false
    },
    moduleNameActive(state) {
      let mName = ''
      if (fnIsObject(state.cfApp.moduleActive) &&
        fnCheckProp(state.cfApp.moduleActive, 'name')) {
        mName = state.cfApp.moduleActive.name
      }

      return mName
    },
    moduleActionListActive(state) {
      let mAction = ''
      if (fnIsObject(state.cfApp.moduleActive) &&
        fnCheckProp(state.cfApp.moduleActive, 'actionList')) {
        mAction = state.cfApp.moduleActive.actionList
      }

      return mAction
    },
  },
  mutations: {
    configApp(state, configs) {
      if (fnIsObject(configs.links)) {
        state.cfApp.links = configs.links
      }
      if (fnIsObject(configs.meta)) {
        state.cfApp.meta = configs.meta
      }
      if (fnIsObject(configs.moduleActive)) {
        state.cfApp.moduleActive = configs.moduleActive
      }
      if (fnIsObject(configs.collectionData)) {
        state.cfApp.collectionData = configs.collectionData
      }
    },
    updateSearchData(state, payload) {
      state.cfApp.searchs = payload
    },
  },
  actions: {
    setConfigApp({
      commit,
    }, configs) {
      const links = (fnCheckProp(configs, 'links')) ? configs.links : undefined
      const meta = (fnCheckProp(configs, 'meta')) ? configs.meta : undefined
      const moduleActive = (fnCheckProp(configs, 'moduleActive')) ? configs.moduleActive : undefined
      const collectionData = (fnCheckProp(configs, 'collectionData')) ? configs.collectionData : undefined

      var _configs = {
        ...defaultState(),
        ...{
          links: links,
          meta: meta,
          moduleActive: moduleActive,
          collectionData: collectionData,
        },
      }

      commit('configApp', _configs)
    },
    updateSearch({ commit, }, searchs) {
      commit('updateSearchData', searchs)
    },
  },
  modules: {
    auth,
    layout,
    dashboard,
    user,
    info,
    news_category,
    app_module,
    linh_muc,
    bang_cap,
    chuc_thanh,
    van_thu,
    thuyen_chuyen,
    giao_phan,
    giao_hat,
    giao_xu,
    giao_diem,
    cong_doan_tu_si,
    dong,
    co_so,
    ban_chuyen_trach,
    thanh,
    chuc_vu,
    le_chinh,
    ngay_le,
    danhmuc_giaophan,
    tintuc_giaophan,
    restrict_ip,
    albums,
    group_albums,
  },
  strict: debug,
  plugins: debug ? [createLogger()] : [],
})