import AppConfig from 'api@admin/constants/app-config'
import { v4 as uuidv4, } from 'uuid'
import { apiInsertInfo, } from 'api@admin/linhmuc'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
} from '../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'
import { fnCheckProp, } from '@app/common/util'
import { getField, updateField } from 'vuex-map-fields'

const defaultState = () => {
  return {
    info: {
      image: '',
      is_duc_cha: false,
      ten_thanh_id: null,
      ten_thanh_name: '',
      ten: '',
      ngay_thang_nam_sinh: null,
      noi_sinh: '',
      giao_xu_id: null,
      giao_xu_name: '',
      ho_ten_cha: '',
      ho_ten_me: '',
      noi_rua_toi: '',
      ngay_rua_toi: null,
      noi_them_suc: '',
      ngay_them_suc: null,
      tieu_chung_vien: null,
      ngay_tieu_chung_vien: null,
      dai_chung_vien: null,
      ngay_dai_chung_vien: null,
      so_cmnd: null,
      noi_cap_cmnd: '',
      ngay_cap_cmnd: null,
      trieu_dong: null,
      ten_dong_id: '',
      ten_dong_name: '',
      ngay_trieu_dong: null,
      ngay_khan: null,
      ngay_rip: null,
      rip_giao_xu_id: null,
      rip_giaoxu_name: '',
      rip_ghi_chu: '',
      ghi_chu: '',
      code: '',
      phone: '',
      email: '',
      password: '',
      sort_id: 0,
      active: 1,

      bang_caps: [],
      chuc_thanhs: [],
      thuyen_chuyens: [],
      van_thus: [],
      bo_nhiems: [],
    },
    isImgChange: true,
    loading: false,
    insertSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    info(state) {
      return state.info
    },
    loading(state) {
      return state.loading
    },
    insertSuccess(state) {
      return state.insertSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
    getInfoField(state) {
      return getField(state.info)
    },
  },

  mutations: {
    UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.banchuyentrachName = payload.banChuyenTrach.name
      state.thuyenChuyen.ban_chuyen_trach_id = payload.banChuyenTrach.id
    },
    UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.dongName = payload.dong.name
      state.thuyenChuyen.dong_id = payload.dong.id
    },
    UPDATE_DROPDOWN_CO_SO_GIAO_PHAN(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.cosogpName = payload.coso.name
      state.thuyenChuyen.co_so_gp_id = payload.coso.id
    },
    UPDATE_DROPDOWN_FROM_GIAO_XU(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.fromgiaoxuName = payload.giaoXu.name
      state.thuyenChuyen.from_giao_xu_id = payload.giaoXu.id
    },
    UPDATE_DROPDOWN_TO_GIAO_XU(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.giaoxuName = payload.giaoXu.name
      state.thuyenChuyen.giao_xu_id = payload.giaoXu.id
    },
    UPDATE_DROPDOWN_FROM_CHUC_VU(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.fromchucvuName = payload.chucVu.name
      state.thuyenChuyen.from_chuc_vu_id = payload.chucVu.id
    },
    UPDATE_DROPDOWN_TO_CHUC_VU(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.chucvuName = payload.chucVu.name
      state.thuyenChuyen.chuc_vu_id = payload.chucVu.id
    },
    UPDATE_DROPDOWN_FROM_DUC_CHA(state, payload) {
      state.thuyenChuyen = payload.thuyenChuyen
      state.thuyenChuyen.ducchaName = payload.ducCha.name
      state.thuyenChuyen.duc_cha_id = payload.ducCha.id
    },
    update_dropdown_thuyen_chuyen(state, payload) {
      const thuyenChuyen = (payload) ? payload : state.thuyenChuyen
      _.forEach(state.info.thuyen_chuyens, function(item, idx) {
        if (fnCheckProp(item, 'id') && item.id == thuyenChuyen.id) {
          state.info.thuyen_chuyens[idx] = thuyenChuyen
        }
      })
    },
    update_thuyen_chuyen(state, payload) {
      state.info.thuyen_chuyens.push(payload)
    },
    update_thuyen_chuyen_remove(state, payload) {
      state.info.thuyen_chuyens = payload
    },
    update_bo_nhiem(state, payload) {
      state.info.bo_nhiems.push(payload)
    },
    update_bo_nhiem_remove(state, payload) {
      state.info.bo_nhiems = payload
    },
    update_van_thu(state, payload) {
      state.info.van_thus.push(payload)
    },
    update_van_thu_remove(state, payload) {
      state.info.van_thus = payload
    },
    update_chuc_thanh(state, payload) {
      state.info.chuc_thanhs.push(payload)
    },
    update_chuc_thanh_remove(state, payload) {
      state.info.chuc_thanhs = payload
    },
    update_bang_cap(state, payload) {
      state.info.bang_caps.push(payload)
    },
    update_bang_cap_remove(state, payload) {
      state.info.bang_caps = payload
    },
    INFO_UPDATE_DONG(state, payload) {
      state.info.ten_dong_id = payload.dong.id
      state.info.ten_dong_name = payload.dong.name
    },
    INFO_UPDATE_DROPDOWN_RIP_GIAO_XU(state, payload) {
      state.info.rip_giao_xu_id = payload.giaoXu.id
      state.info.rip_giaoxu_name = payload.giaoXu.name
    },
    INFO_UPDATE_DROPDOWN_GIAO_XU(state, payload) {
      state.info.giao_xu_id = payload.giaoXu.id
      state.info.giao_xu_name = payload.giaoXu.name
    },
    INFO_UPDATE_DROPDOWN_TEN_THANH_LIST(state, payload) {
      state.info.ten_thanh_id = payload.tenThanh.id
      state.info.ten_thanh_name = payload.tenThanh.name
    },
    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },
    [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.insertSuccess = payload
    },
    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.insertSuccess = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload
      state.isImgChange = true
    },
    updateInfoField(state, field) {
      return updateField(state.info, field)
    },
  },

  actions: {
    ACTION_UPDATE_DROPDOWN_DONG({ commit, }, params) {
      commit('INFO_UPDATE_DONG', params)
    },
    ACTION_UPDATE_DROPDOWN_RIP_GIAO_XU({ commit, }, params) {
      commit('INFO_UPDATE_DROPDOWN_RIP_GIAO_XU', params)
    },
    ACTION_UPDATE_DROPDOWN_GIAO_XU({ commit, }, params) {
      commit('INFO_UPDATE_DROPDOWN_GIAO_XU', params)
    },
    ACTION_UPDATE_DROPDOWN_TEN_THANH_LIST({ commit, }, params) {
      commit('INFO_UPDATE_DROPDOWN_TEN_THANH_LIST', params)
    },
    addBangCaps({ commit, }) {
      commit('update_bang_cap', {
        id: uuidv4(),
        name: '',
        type: 0,
        ghi_chu: '',
        active: 1,
      })
    },
    removeBangCap({ commit, state, }, params) {
      let bangCaps = state.info.bang_caps
      const data = params.item
      commit(
        'update_bang_cap_remove',
        _.remove(bangCaps, (item) => {
          return !(item.id == data.id)
        })
      )
    },
    addChucThanhs({ commit, }) {
      commit('update_chuc_thanh', {
        id: uuidv4(),
        chuc_thanh_id: 1,
        ngay_thang_nam_chuc_thanh: null,
        noi_thu_phong: '',
        nguoi_thu_phong: '',
        ghi_chu: '',
        active: 1,
      })
    },
    removeChucThanh({ commit, state, }, params) {
      let chucThanhs = state.info.chuc_thanhs
      const data = params.item
      commit(
        'update_chuc_thanh_remove',
        _.remove(chucThanhs, (item) => {
          return !(item.id == data.id)
        })
      )
    },
    addVanThus({ commit, }) {
      commit('update_van_thu', {
        id: uuidv4(),
        parent_id: 0,
        title: null,
        type: '',
        ghi_chu: '',
        active: 1,
      })
    },
    removeVanThu({ commit, state, }, params) {
      let vanThus = state.info.van_thus
      const data = params.item

      commit(
        'update_van_thu_remove',
        _.remove(vanThus, (item) => {
          return !(item.id == data.id)
        })
      )
    },
    addThuyenChuyen({ commit, }) {
      commit('update_thuyen_chuyen', {
        id: uuidv4(),
        from_giao_xu_id: null,
        fromgiaoxuName: '',
        from_chuc_vu_id: null,
        fromchucvuName: '',
        from_date: null,
        duc_cha_id: null,
        ducchaName: '',
        to_date: null,
        chuc_vu_id: null,
        chucvuName: '',
        giao_xu_id: null,
        giaoxuName: '',
        co_so_gp_id: null,
        cosogpName: '',
        dong_id: null,
        dongName: '',
        ban_chuyen_trach_id: null,
        banchuyentrachName: '',
        du_hoc: null,
        quoc_gia: null,
        ghi_chu: '',
        active: 1,
      })
    },
    removeThuyenChuyen({ commit, state, }, params) {
      let thuyenChuyens = state.info.thuyen_chuyens
      const data = params.item
      commit(
        'update_thuyen_chuyen_remove',
        _.remove(thuyenChuyens, (item) => {
          return !(item.id == data.id)
        })
      )
    },
    addBoNhiem({ commit, }, boNhiem) {
      commit('update_bo_nhiem', {
        id: uuidv4(),
        ...boNhiem.data,
      })
    },
    removeBoNhiem({ commit, state, }, params) {
      let boNhiems = state.info.bo_nhiems
      const data = params.item
      commit(
        'update_bo_nhiem_remove',
        _.remove(boNhiems, (item) => {
          return !(item.id == data.id)
        })
      )
    },
    ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH(
      { commit, },
      params
    ) {
      commit('UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG({ commit, }, params) {
      commit('UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    ACTION_UPDATE_DROPDOWN_CO_SO_GIAO_PHAN({ commit, }, params) {
      commit('UPDATE_DROPDOWN_CO_SO_GIAO_PHAN', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    ACTION_UPDATE_DROPDOWN_FROM_GIAO_XU({ commit, }, params) {
      commit('UPDATE_DROPDOWN_FROM_GIAO_XU', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    ACTION_UPDATE_DROPDOWN_TO_GIAO_XU({ commit, }, params) {
      commit('UPDATE_DROPDOWN_TO_GIAO_XU', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    ACTION_UPDATE_DROPDOWN_FROM_CHUC_VU({ commit, }, params) {
      commit('UPDATE_DROPDOWN_FROM_CHUC_VU', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    ACTION_UPDATE_DROPDOWN_TO_CHUC_VU({ commit, }, params) {
      commit('UPDATE_DROPDOWN_TO_CHUC_VU', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    ACTION_UPDATE_DROPDOWN_FROM_DUC_CHA({ commit, }, params) {
      commit('UPDATE_DROPDOWN_FROM_DUC_CHA', params)
      commit('update_dropdown_thuyen_chuyen')
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading)
    },
    [ACTION_INSERT_INFO]({ dispatch, commit, }, info) {
      apiInsertInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            commit(SET_ERROR, [])
            dispatch(ACTION_SET_LOADING, false)
          }
          window.location.reload()
        },
        (errors) => {
          commit(
            INFOS_MODAL_INSERT_INFO_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },
    [ACTION_INSERT_INFO_BACK]({ dispatch, commit, }, info) {
      apiInsertInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            dispatch('MODULE_LINH_MUC_ACTION_RELOAD_INFO_LIST', 'page', {
              root: true,
            })
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_INSERT_INFO_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },
    [ACTION_SET_IMAGE]({ commit, }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
    },
    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(INFOS_MODAL_INSERT_INFO_SUCCESS, values)
    },
  },
}
