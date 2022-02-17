import adds from './add'
import edits from './edit'
import {
  apiGetInfoById,
  apiGetLinhMucInfos,
  apiDeleteInfo,
  apiGetDropdownCategories,
} from 'api@admin/linhmuc'
import { MODULE_MODULE_LINH_MUC, } from '../types/module-types'
import {
  INFOS_SET_LOADING,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_DELETE_INFO_BY_ID_SUCCESS,
  INFOS_DELETE_INFO_BY_ID_FAILED,
  INFOS_SET_INFO_LIST,
  INFOS_INFO_DELETE_BY_ID,
  INFOS_SET_INFO_DELETE_BY_ID_FAILED,
  INFOS_SET_INFO_DELETE_BY_ID_SUCCESS,
  SET_ERROR,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  NEWSGROUPS_FORM_SET_DROPDOWN_CATEGORY_LIST,
} from '../types/mutation-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_DELETE_INFO_BY_ID,
  ACTION_SET_INFO_DELETE_BY_ID,
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'
import { config, } from '@app/common/config'
import { fnCheckProp, } from '@app/common/util'

const defaultState = () => {
  return {
    infos: [],
    total: 0,
    infoDelete: null,
    isDelete: false,
    isList: false,
    dropdownGiaoXus: [],
    dropdownThanhs: [],
    dropdownChucVus: [],
    dropdownDucChas: [],
    dropdownCoSoGiaoPhans: [],
    dropdownBanChuyenTrachs: [],
    dropdownDongs: [],
		dropdownLinhMucs: [],
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    infos(state) {
      return state.infos
    },
    loading(state) {
      return state.loading
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
  },

  mutations: {
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
		SET_DROPDOWN_LINH_MUC_LIST(state, payload) {
      state.dropdownLinhMucs = payload
    },
    SET_DROPDOWN_CHUC_VU_LIST(state, payload) {
      state.dropdownChucVus = payload
    },
    SET_DROPDOWN_TEN_THANH_LIST(state, payload) {
      state.dropdownThanhs = payload
    },
    [NEWSGROUPS_FORM_SET_DROPDOWN_CATEGORY_LIST](state, payload) {
      state.dropdownGiaoXus = payload
    },
    [MODULE_UPDATE_SETTING_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SETTING_FAILED](state, payload) {
      state.updateSuccess = payload
    },
    [INFOS_SET_INFO_LIST](state, payload) {
      state.infos = payload
    },
    [INFOS_INFO_DELETE_BY_ID](state, payload) {
      state.infoDelete = payload
    },
    [INFOS_SET_INFO_DELETE_BY_ID_FAILED](state, payload) {
      state.isDelete = payload
    },
    [INFOS_SET_INFO_DELETE_BY_ID_SUCCESS](state, payload) {
      state.isDelete = payload
    },
    [INFOS_GET_INFO_LIST_SUCCESS](state, payload) {
      state.isList = payload
    },
    [INFOS_GET_INFO_LIST_FAILED](state, payload) {
      state.isList = payload
    },
    [INFOS_DELETE_INFO_BY_ID_SUCCESS](state, payload) {
      state.isDelete = payload
    },
    [INFOS_DELETE_INFO_BY_ID_FAILED](state, payload) {
      state.isDelete = false
      state.errors = payload
    },
    [INFOS_SET_LOADING](state, payload) {
      state.loading = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },

  actions: {
    ACTION_GET_DROPDOWN_BAN_CHUYEN_TRACH_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.ban.chuyen.trach',
      }
      apiGetDropdownCategories(
        (result) => {
          commit('SET_DROPDOWN_BAN_CHUYEN_TRACH_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
    ACTION_GET_DROPDOWN_DONG_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.dong',
      }
      apiGetDropdownCategories(
        (result) => {
          commit('SET_DROPDOWN_DONG_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
    ACTION_GET_DROPDOWN_CO_SO_GIAO_PHAN_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.co.so.giao.phan',
      }
      apiGetDropdownCategories(
        (result) => {
          commit('SET_DROPDOWN_CO_SO_GIAO_PHAN_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
    ACTION_GET_DROPDOWN_DUC_CHA_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.duc.cha',
      }
      apiGetDropdownCategories(
        (result) => {
          commit('SET_DROPDOWN_DUC_CHA_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
		ACTION_GET_DROPDOWN_LINH_MUC_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.linh.muc',
      }
      apiGetDropdownCategories(
        (result) => {
          commit('SET_DROPDOWN_LINH_MUC_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
    ACTION_GET_DROPDOWN_CHUC_VU_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.chuc.vu',
      }
      apiGetDropdownCategories(
        (result) => {
          commit('SET_DROPDOWN_CHUC_VU_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
    ACTION_GET_DROPDOWN_TEN_THANH_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.ten.thanh',
      }
      apiGetDropdownCategories(
        (result) => {
          commit('SET_DROPDOWN_TEN_THANH_LIST', result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
    ACTION_GET_DROPDOWN_GIAO_XU_LIST({ commit, }, filterName) {
      const params = {
        filter_name: filterName,
        action: 'dropdown.giao.xu',
      }
      apiGetDropdownCategories(
        (result) => {
          commit(NEWSGROUPS_FORM_SET_DROPDOWN_CATEGORY_LIST, result)
        },
        (errors) => {
          commit(SET_ERROR, errors)
        },
        params
      )
    },
    async [ACTION_GET_INFO_LIST]({ dispatch, commit, }, params) {
      dispatch(ACTION_SET_LOADING, true)
      await apiGetLinhMucInfos(
        (infos) => {
          commit(INFOS_SET_INFO_LIST, infos.data.results)
          commit(INFOS_GET_INFO_LIST_SUCCESS, true)
          var pagination = {
            current_page: 1,
            total: 0,
          }
          if (fnCheckProp(infos.data, 'pagination')) {
            pagination = infos.data.pagination
          }
          var configs = {
            moduleActive: {
              name: MODULE_MODULE_LINH_MUC,
              actionList: ACTION_GET_INFO_LIST,
            },
            collectionData: pagination,
          }
          dispatch('setConfigApp', configs, {
            root: true,
          })
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, errors)
          dispatch(ACTION_SET_LOADING, false)
        },
        params
      )
    },
    async [ACTION_DELETE_INFO_BY_ID]({ state, dispatch, commit, }, infoId) {
      let getId = null
      if (typeof state.infoDelete === 'object') {
        if (fnCheckProp(state.infoDelete, 'information_id')) {
          getId = parseInt(state.infoDelete.information_id)
        }
      }
      const deleteId = parseInt(infoId)
      if (getId === deleteId) {
        await apiDeleteInfo(
          deleteId,
          (infos) => {
            if (infos) {
              commit(INFOS_DELETE_INFO_BY_ID_SUCCESS, true)
              dispatch(ACTION_GET_INFO_LIST)
              commit(INFOS_INFO_DELETE_BY_ID, null)
            }
          },
          (errors) => {
            commit(INFOS_DELETE_INFO_BY_ID_FAILED, false)
            if (errors) {
              commit(SET_ERROR, errors)
            }
          }
        )
      }
    },
    [ACTION_SET_INFO_DELETE_BY_ID]({ commit, }, infoId) {
      apiGetInfoById(
        infoId,
        (result) => {
          commit(INFOS_INFO_DELETE_BY_ID, result.data)
          commit(INFOS_SET_INFO_DELETE_BY_ID_SUCCESS, true)
        },
        (errors) => {
          commit(INFOS_SET_INFO_DELETE_BY_ID_FAILED, false)
          if (errors) {
            commit(SET_ERROR, errors)
          }
        }
      )
    },
    MODULE_LINH_MUC_ACTION_RELOAD_INFO_LIST: {
      root: true,
      handler() {
        return fn_redirect_url(
          `/${config.adminPrefix}/linh-mucs`
        )
      },
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_SET_LOADING, isLoading)
    },
    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(MODULE_UPDATE_SETTING_SUCCESS, values)
    },
  },
  modules: {
    add: adds,
    edit: edits,
  },
}
