import { apiGetDetail, } from '@app/api/front/linhmucs'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_DETAIL_LINH_MUC, } from '@app/stores/front/types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    infoRelateds: [],
    errors: [],
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus
    },
    pageLists(state) {
      return state.pageLists
    },
    infoRelateds(state) {
      return state.infoRelateds
    },
  }, 
  mutations: {
    [INIT_LIST](state, payload) {
      state.pageLists = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },
  actions: {
    [GET_DETAIL_LINH_MUC]({ commit, }, routeParams) {
      apiGetDetail(routeParams.linhMucId,
        (responses) => {
          commit(INIT_LIST, responses.data[0])
          const detail = responses.data[0]
          if (detail.id) {
            let authLm = localStorage.getItem('authen-lm')
            const redUrl = `/linhmucadmin?linhmucId=${detail.id}`
            if (authLm) {
              authLm = JSON.parse(authLm)
              if (!Object.keys(authLm).length) {
                return fn_redirect_url(redUrl)
              }
              if (!authLm.hasOwnProperty('auth')) {
                return fn_redirect_url(redUrl)
              }
              if (!authLm.auth.hasOwnProperty('user')) {
                return fn_redirect_url(redUrl)
              }
              if (!authLm.auth.user.hasOwnProperty('uid')) {
                return fn_redirect_url(redUrl)
              }
            } else {
              return fn_redirect_url(redUrl)
            }
          }
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }, routeParams)
    },
  },
}