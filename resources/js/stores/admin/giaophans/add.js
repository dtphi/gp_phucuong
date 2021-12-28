import AppConfig from 'api@admin/constants/app-config'
import { v4 as uuidv4, } from 'uuid'
import { apiInsertInfo, } from 'api@admin/giaophan'
import {
  INFOS_SET_LOADING,
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

const defaultState = () => {
  return {
    info: {
      image: '',
      name: '',
      khai_quat: '',
      sort_id: '',
      active: 1,
      update_user: '',
      giao_phan_hats: [],
      giao_phan_dongs: [],
      giao_phan_cosos: [],
      giao_phan_banchuyentrachs: [],
      giao_phan_hat_xu_diems: [],
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
    giaoXus(state) {
      let giaoXus = []
      _.forEach(state.info.giao_phan_hats, function(item) {
        giaoXus = _.concat(giaoXus, item.giao_xus)
      })

      return giaoXus
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
  },

  mutations: {
    update_giao_xu_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, (item, idx) => {
        if (fnCheckProp(item, 'id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx].giao_xus = payload.giao_xus
        }
      })
    },
    update_dropdown_giao_xu_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, (item, idx) => {
        if (
          fnCheckProp(item, 'id') &&
                    fnCheckProp(item, 'giao_xus') &&
                    item.id == payload.hatId
        ) {
          _.forEach(item.giao_xus, (gx, index) => {
            if (fnCheckProp(gx, 'id') && gx.id == payload.id) {
              state.info.giao_phan_hats[idx].giao_xus[index] =
                                payload
            }
          })
        }
      })
    },
    update_congdts_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, (item, idx) => {
        if (fnCheckProp(item, 'id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx].cong_doan_tu_sis =
                        payload.cong_doan_tu_sis
        }
      })
    },
    update_dropdown_congdts_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, (item, idx) => {
        if (
          fnCheckProp(item, 'id') &&
                    fnCheckProp(item, 'cong_doan_tu_sis') &&
                    item.id == payload.hatId
        ) {
          _.forEach(item.cong_doan_tu_sis, (cdts, index) => {
            if (fnCheckProp(cdts, 'id') && cdts.id == payload.id) {
              state.info.giao_phan_hats[idx].cong_doan_tu_sis[
                index
              ] = payload
            }
          })
        }
      })
    },
    update_hat_in_giao_phan(state, payload) {
      state.info.giao_phan_hats = payload
    },
    update_dropdown_hat_in_giao_phan(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (fnCheckProp(item, 'id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx] = payload
        }
      })
    },
    update_dong_in_giao_phan(state, payload) {
      state.info.giao_phan_dongs = payload
    },
    update_dropdown_dong_in_giao_phan(state, payload) {
      _.forEach(state.info.giao_phan_dongs, function(item, idx) {
        if (fnCheckProp(item, 'id') && item.id == payload.id) {
          state.info.giao_phan_dongs[idx] = payload
        }
      })
    },
    update_coso_in_giao_phan(state, payload) {
      state.info.giao_phan_cosos = payload
    },
    update_dropdown_coso_in_giao_phan(state, payload) {
      _.forEach(state.info.giao_phan_cosos, function(item, idx) {
        if (fnCheckProp(item, 'id') && item.id == payload.id) {
          state.info.giao_phan_cosos[idx] = payload
        }
      })
    },
    update_banchuyentrach_in_giao_phan(state, payload) {
      state.info.giao_phan_banchuyentrachs = payload
    },
    update_dropdown_banchuyentrach_in_giao_phan(state, payload) {
      _.forEach(
        state.info.giao_phan_banchuyentrachs,
        function(item, idx) {
          if (fnCheckProp(item, 'id') && item.id == payload.id) {
            state.info.giao_phan_banchuyentrachs[idx] = payload
          }
        }
      )
    },
    [INFOS_SET_LOADING](state, payload) {
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
  },

  actions: {
    addHatCongDoanTuSiGiaoPhan({ commit, }, params) {
      let giaoHat = params.giaoHat
      giaoHat.cong_doan_tu_sis.push({
        id: uuidv4(),
        hatId: giaoHat.id,
        giao_hat_id: giaoHat.giao_hat_id,
        cong_doan_tu_si_id: null,
        hatCongDtsName: '',
        active: 1,
      })
      commit('update_congdts_in_hat', giaoHat)
    },
    removeHatCongDoanTuSiGiaoPhan({ commit, }, params) {
      let giaoHat = params.giaoHat
      let congDts = params.giaoHat.cong_doan_tu_sis
      let congDtsRm = params.congDoanTuSi
      giaoHat.cong_doan_tu_sis = _.remove(congDts, function(item) {
        return !(
          item.id == congDtsRm.id && item.hatId == congDtsRm.hatId
        )
      })
      commit('update_congdts_in_hat', giaoHat)
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_CONGDTS_LIST({ commit, }, params) {
      let hatCongdtsUpdate = params.hatCongDts
      _.forEach(params.hat.cong_doan_tu_sis, (item) => {
        if (fnCheckProp(item, 'id') && item.id == hatCongdtsUpdate.id) {
          hatCongdtsUpdate = _.update(
            item,
            'cong_doan_tu_si_id',
            (cong_doan_tu_si_id) => {
              cong_doan_tu_si_id = params.hatCongDtsInfo.id

              return cong_doan_tu_si_id
            }
          )
          hatCongdtsUpdate = _.update(
            item,
            'hatCongDtsName',
            (hatCongDtsName) => {
              hatCongDtsName = params.hatCongDtsInfo.name

              return hatCongDtsName
            }
          )
          commit('update_dropdown_congdts_in_hat', hatCongdtsUpdate)
        }
      })
    },
    addHatXuGiaoPhan({ commit, }, params) {
      let giaoHat = params.giaoHat
      giaoHat.giao_xus.push({
        id: uuidv4(),
        hatId: giaoHat.id,
        giao_hat_id: giaoHat.giao_hat_id,
        giao_xu_id: null,
        hatXuName: '',
        active: 1,
        giao_xu_diems: [],
      })
      commit('update_giao_xu_in_hat', giaoHat)
    },
    removeHatXuGiaoPhan({ commit, }, params) {
      let giaoHat = params.giaoHat
      let giaoXus = params.giaoHat.giao_xus
      let giaoXuRm = params.giaoXu
      giaoHat.giao_xus = _.remove(giaoXus, function(item) {
        return !(item.id == giaoXuRm.id && item.hatId == giaoXuRm.hatId)
      })
      commit('update_giao_xu_in_hat', giaoHat)
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_XU_LIST({ commit, }, params) {
      let hatXuUpdate = params.hatXu
      _.forEach(params.hat.giao_xus, (item) => {
        if (fnCheckProp(item, 'id') && item.id == hatXuUpdate.id) {
          hatXuUpdate = _.update(item, 'giao_xu_id', (giao_xu_id) => {
            giao_xu_id = params.hatXuInfo.id

            return giao_xu_id
          })
          hatXuUpdate = _.update(item, 'hatXuName', (hatXuName) => {
            hatXuName = params.hatXuInfo.name

            return hatXuName
          })
          commit('update_dropdown_giao_xu_in_hat', hatXuUpdate)
        }
      })
    },
    addHatGiaoPhan({ commit, state, }) {
      let giaoHats = state.info.giao_phan_hats
      giaoHats.push({
        id: uuidv4(),
        giao_hat_id: null,
        hatName: '',
        active: 1,
        giao_xus: [],
        cong_doan_tu_sis: [],
      })
      commit('update_hat_in_giao_phan', giaoHats)
    },
    removeHatGiaoPhan({ commit, state, }, params) {
      let giaoPhanHats = state.info.giao_phan_hats
      const data = params.item
      giaoPhanHats = _.remove(giaoPhanHats, (item) => {
        return !(item.id == data.id)
      })
      commit('update_hat_in_giao_phan', giaoPhanHats)
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST({ commit, state, }, params) {
      let hat = params.hat
      let giaoHats = state.info.giao_phan_hats
      _.forEach(giaoHats, (item) => {
        if (fnCheckProp(item, 'id') && item.id == params.hat.id) {
          hat = _.update(item, 'giao_hat_id', (giao_hat_id) => {
            giao_hat_id = params.hatInfo.id

            return giao_hat_id
          })
          hat = _.update(item, 'hatName', (hatName) => {
            hatName = params.hatInfo.name

            return hatName
          })
          commit('update_dropdown_hat_in_giao_phan', hat)
        }
      })
    },
    addDongGiaoPhan({ commit, state, }) {
      let dongs = state.info.giao_phan_dongs
      dongs.push({
        id: uuidv4(),
        dong_id: null,
        dongName: '',
        active: 1,
      })
      commit('update_dong_in_giao_phan', dongs)
    },
    removeDongGiaoPhan({ commit, state, }, params) {
      let giaoPhanDongs = state.info.giao_phan_dongs
      const data = params.item
      giaoPhanDongs = _.remove(giaoPhanDongs, (item) => {
        return !(item.id == data.id)
      })
      commit('update_dong_in_giao_phan', giaoPhanDongs)
    },
    ACTION_UPDATE_DROPDOWN_DONG_LIST({ commit, state, }, params) {
      let dong = params.dong
      let dongs = state.info.giao_phan_dongs
      _.forEach(dongs, (item) => {
        if (fnCheckProp(item, 'id') && item.id == params.dong.id) {
          dong = _.update(item, 'dong_id', (dong_id) => {
            dong_id = params.dongInfo.id

            return dong_id
          })
          dong = _.update(item, 'dongName', (dongName) => {
            dongName = params.dongInfo.name

            return dongName
          })
          commit('update_dropdown_dong_in_giao_phan', dong)
        }
      })
    },
    addCoSoGiaoPhan({ commit, state, }) {
      let cosos = state.info.giao_phan_cosos
      cosos.push({
        id: uuidv4(),
        co_so_giao_phan_id: null,
        cosoName: '',
        active: 1,
      })
      commit('update_coso_in_giao_phan', cosos)
    },
    removeCoSoGiaoPhan({ commit, state, }, params) {
      let giaoPhanCosos = state.info.giao_phan_cosos
      const data = params.item
      giaoPhanCosos = _.remove(giaoPhanCosos, (item) => {
        return !(item.id == data.id)
      })
      commit('update_coso_in_giao_phan', giaoPhanCosos)
    },
    ACTION_UPDATE_DROPDOWN_COSO_LIST({ commit, state, }, params) {
      let coso = params.coso
      let cosos = state.info.giao_phan_cosos
      _.forEach(cosos, (item) => {
        if (fnCheckProp(item, 'id') && item.id == params.coso.id) {
          coso = _.update(
            item,
            'co_so_giao_phan_id',
            (co_so_giao_phan_id) => {
              co_so_giao_phan_id = params.cosoInfo.id

              return co_so_giao_phan_id
            }
          )
          coso = _.update(item, 'cosoName', (cosoName) => {
            cosoName = params.cosoInfo.name

            return cosoName
          })
          commit('update_dropdown_coso_in_giao_phan', coso)
        }
      })
    },
    addBanChuyenTrachGiaoPhan({ commit, state, }) {
      let banChuyenTrachs = state.info.giao_phan_banchuyentrachs
      banChuyenTrachs.push({
        id: uuidv4(),
        ban_chuyen_trach_id: null,
        banChuyenTrachName: '',
        active: 1,
      })
      commit('update_banchuyentrach_in_giao_phan', banChuyenTrachs)
    },
    removeBanChuyenTrachGiaoPhan({ commit, state, }, params) {
      let giaoPhanBanChuyenTrachs = state.info.giao_phan_banchuyentrachs
      const data = params.item
      giaoPhanBanChuyenTrachs = _.remove(
        giaoPhanBanChuyenTrachs,
        (item) => {
          return !(item.id == data.id)
        }
      )
      commit(
        'update_banchuyentrach_in_giao_phan',
        giaoPhanBanChuyenTrachs
      )
    },
    ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST({ commit, state, }, params) {
      let banChuyenTrach = params.banChuyenTrach
      let banChuyenTrachs = state.info.giao_phan_banchuyentrachs
      _.forEach(banChuyenTrachs, (item) => {
        if (
          fnCheckProp(item, 'id') &&
                    item.id == params.banChuyenTrach.id
        ) {
          banChuyenTrach = _.update(
            item,
            'ban_chuyen_trach_id',
            (ban_chuyen_trach_id) => {
              ban_chuyen_trach_id = params.banChuyenTrachInfo.id

              return ban_chuyen_trach_id
            }
          )
          banChuyenTrach = _.update(
            item,
            'banChuyenTrachName',
            (banChuyenTrachName) => {
              banChuyenTrachName = params.banChuyenTrachInfo.name

              return banChuyenTrachName
            }
          )
          commit(
            'update_dropdown_banchuyentrach_in_giao_phan',
            banChuyenTrach
          )
        }
      })
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_SET_LOADING, isLoading)
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
          }
          window.location.reload()
          dispatch(ACTION_SET_LOADING, false)
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
            dispatch('ACTION_RELOAD_INFO_LIST', 'page', {
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
