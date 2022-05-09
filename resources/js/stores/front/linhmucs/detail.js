import {
  apiGetDetail, apiLinhMucUpdateById, apiUpdateLinhMucTemp, apiGetHoatDongSuVu,
  apiGetDropdownCategories, apiAddThuyenChuyen
} from '@app/api/front/linhmucs'
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
    linhmuc_update: {},
    arr_thuyen_chuyens: [],
    dropdownGiaoXus: [],
    dropdownThanhs: [],
    dropdownChucVus: [],
    dropdownDucChas: [],
    dropdownCoSoGiaoPhans: [],
    dropdownBanChuyenTrachs: [],
    dropdownDongs: [],
    dropdownCongDoanNgoaiGiaoPhans: [],
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
    },
    arr_thuyen_chuyens(state) {
      return state.list_hdsv
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
    },
    SET_HDSV(state, payload) {
      state.arr_thuyen_chuyens = payload
    },
    SET_DROPDOWN_GIAO_XU_LIST(state, payload) {
      state.dropdownGiaoXus = payload
    },
    SET_DROPDOWN_BAN_CHUYEN_TRACH_LIST(state, payload) {
      state.dropdownBanChuyenTrachs = payload
    },
    SET_DROPDOWN_DONG_LIST(state, payload) {
      state.dropdownDongs = payload
    },
    SET_DROPDOWN_CO_SO_GIAO_PHAN_LIST(state, payload) {
      state.dropdownCoSoGiaoPhans = payload
    },
    SET_DROPDOWN_DUC_CHA_LIST(state, payload) {
      state.dropdownDucChas = payload
    },
    SET_DROPDOWN_CHUC_VU_LIST(state, payload) {
      state.dropdownChucVus = payload
    },
    SET_DROPDOWN_TEN_THANH_LIST(state, payload) {
      state.dropdownThanhs = payload
    },
    SET_DROPDOWN_CONG_DOAN_NGOAI_GIAO_PHAN_LIST(state, payload) {
      state.dropdownCongDoanNgoaiGiaoPhans = payload
    },
    SET_DELETE_THUYEN_CHUYEN(state, payload) {
      const i = state.arr_thuyen_chuyens.map(item => item.id).indexOf(payload)
      state.arr_thuyen_chuyens.splice(i, 1)
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
          alert('Cập nhật thông tin thành công !!!')
          window.location.reload(true);
        },
        (err) => {
          console.log(err)
        }
      )
    },
    GET_HOAT_DONG_SU_VU({ commit }, update_linhmuc) {
      const id = update_linhmuc.linhMucId
      apiGetHoatDongSuVu(
        id,
        (res) => {
          commit('SET_HDSV', res.data.results)
        },
        (err) => {
          console.log(err)
        }
      ) 
    },
    GET_LIST_GIAO_XU({ commit }) {
      const action = 'dropdown.giao.xu';
      const params = { action: action }
      apiGetDropdownCategories(
        params,
        (res) => {
          commit('SET_DROPDOWN_GIAO_XU_LIST', res)
        },
        (err) => {
          console.log(err, 'err')
        }
      )
    },
    GET_LIST_BAN_CHUYEN_TRACH({ commit}) {
      const action = 'dropdown.ban.chuyen.trach';
      const params = {
        action: action
      }
      apiGetDropdownCategories(
        params,
        (result) => {
          commit('SET_DROPDOWN_BAN_CHUYEN_TRACH_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }
      )
    },
    GET_LIST_DONG({ commit, }) {
      const action = 'dropdown.dong';
      const params = {
        action: action,
      }
      apiGetDropdownCategories(
        params,
        (result) => {
          commit('SET_DROPDOWN_DONG_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }
      )
    },
    GET_LIST_CSGP({ commit, }) {
      const action = 'dropdown.co.so.giao.phan';
      const params = {
        action: action,
      }
      apiGetDropdownCategories(
        params,
        (result) => {
          commit('SET_DROPDOWN_CO_SO_GIAO_PHAN_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }      
      )
    },
    GET_LIST_DUC_CHA({ commit, }) {
      const action = 'dropdown.duc.cha'
      const params = {
        action: action,
      }
      apiGetDropdownCategories(
        params,
        (result) => {
          commit('SET_DROPDOWN_DUC_CHA_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
      )
    },
    GET_LIST_CHUC_VU({ commit, }) {
      const action = 'dropdown.chuc.vu';
      const params = {
        action: action,
      }
      apiGetDropdownCategories(
        params,
        (result) => {
          commit('SET_DROPDOWN_CHUC_VU_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }
      )
    },
    GET_LIST_THANH({ commit, }) {
      const action = 'dropdown.ten.thanh';
      const params = {
        action: action,
      }
      apiGetDropdownCategories(
        params,
        (result) => {
          commit('SET_DROPDOWN_TEN_THANH_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }     
      )
    },
    GET_LIST_CSNGP({ commit, }) {
      const action = 'dropdown.cong.doan.ngoai.giao.phan';
      const params = {
        action: action,
      }
      apiGetDropdownCategories(
        params,
        (result) => {
          commit('SET_DROPDOWN_CONG_DOAN_NGOAI_GIAO_PHAN_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },      
      )
    },
    ADD_THUYEN_CHUYEN({ commit }, params) {
      apiAddThuyenChuyen(
        params,
        (res) => {
          window.location.reload(true);
        },
        (err) => {
          console.log(err, 'err')
        }
      )
    },
    UPDATE_THUYEN_CHUYEN({ commit }, params) {
      apiAddThuyenChuyen(
        params,
        (res) => {
          window.location.reload(true);
        },
        (err) => {
          console.log(err, 'err')
        }
      )
    },
    DELETE_THUYEN_CHUYEN({ commit }, id) {
      const params = {id: id, action: 'delete.thuyen.chuyen'}
      commit('SET_DELETE_THUYEN_CHUYEN', id)
      apiAddThuyenChuyen(
        params,
        (res) => {
          // alert('Xóa thành công !!!')
        },
        (err) => {
          console.log(err, 'err')
        }
      )
    }
  },
}