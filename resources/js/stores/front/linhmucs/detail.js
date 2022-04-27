import { apiGetDetail, apiLinhMucUpdateById, apiUpdateLinhMucTemp} from '@app/api/front/linhmucs'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_DETAIL_LINH_MUC, } from '@app/stores/front/types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'
import { fnCheckProp, } from '@app/common/util'

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    infoRelateds: [],
    errors: [],
    linhmuc_update: {}
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
    linhmuc_update(state) {
      return state.linhmuc_update
    }
  }, 
  mutations: {
    [INIT_LIST](state, payload) {
      state.pageLists = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
    SET_LINH_MUC_UPDATE(state, payload) {
      state.linhmuc_update = payload
    }
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
              if (!fnCheckProp(authLm, 'auth')) {
                return fn_redirect_url(redUrl)
              }
              if (!fnCheckProp(authLm.auth, 'user')) {
                return fn_redirect_url(redUrl)
              }
              if (!fnCheckProp(authLm.auth.user, 'uid')) {
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
    GET_LINH_MUC_UPDATE_BY_ID({commit}, routeParams) {
      apiLinhMucUpdateById(
        routeParams.linhMucId,
        (responses) => {
          commit('SET_LINH_MUC_UPDATE', responses.data[0]);
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }
      )
    },
    UPDATE_LINH_MUC_DETAIL({ commit }, update_linhmuc) {
      apiUpdateLinhMucTemp(
        update_linhmuc,
        (res) => {
          commit('SET_LINH_MUC_UPDATE',update_linhmuc)
        },
        (err) => {
          console.log(err)
        }
      )
    } 
  },
}