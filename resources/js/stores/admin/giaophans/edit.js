import AppConfig from 'api@admin/constants/app-config'
import { v4 as uuidv4, } from 'uuid'
import { apiUpdateInfo, apiGetInfoById, } from 'api@admin/giaophan'
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
  ACTION_GET_INFO_BY_ID,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'
import _ from 'lodash'
import { fnCheckProp, } from '@app/common/util'

const defaultState = () => {
  return {
    info: {
      id: null,
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
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    isOpen(state) {
      return state.isOpen
    },
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
    updateSuccess(state) {
      return state.updateSuccess
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
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (fnCheckProp(item, 'id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx].giao_xus = payload.giao_xus
        }
      })
    },
    update_dropdown_giao_xu_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (
          fnCheckProp(item, 'id') &&
                    fnCheckProp(item, 'giao_xus') &&
                    item.id == payload.hatId
        ) {
          _.forEach(item.giao_xus, function(gx, index) {
            if (fnCheckProp(gx, 'id') && gx.id == payload.id) {
              state.info.giao_phan_hats[idx].giao_xus[index] =
                                payload
            }
          })
        }
      })
    },
    update_congdts_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (fnCheckProp(item, 'id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx].cong_doan_tu_sis =
                        payload.cong_doan_tu_sis
        }
      })
    },
    update_dropdown_congdts_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (
          fnCheckProp(item, 'id') &&
                    fnCheckProp(item, 'cong_doan_tu_sis') &&
                    item.id == payload.hatId
        ) {
          _.forEach(item.cong_doan_tu_sis, function(cdts, index) {
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
      state.updateSuccess = payload
    },
    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload
      state.isImgChange = true
    },
    GIAO_PHANS_SET_INFO(state, payload) {
      state.info = payload
    },
  },

  actions: {
    addHatCongDoanTuSiGiaoPhan({ commit, }, params) {
      let giaoHat = params.giaoHat
      giaoHat.cong_doan_tu_sis.push({
        id: uuidv4(),
        isCheck: false,
        isEdit: 0,
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
    checkAllCongDoanTuSi({ state, }, check) {
      _.forEach(state.info.van_thus, function(item) {
        _.update(item, 'isCheck', function(isCheck) {
          isCheck = check

          return isCheck
        })
      })
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_CONGDTS_LIST(
      { commit, state, dispatch, },
      params
    ) {
      let hatCongdtsUpdate = params.hatCongDts
      if (
        fnCheckProp(params, 'action') &&
                params.action === 'create.update.hat.congdts.db'
      ) {
        //implement
        hatCongdtsUpdate['giao_phan_id'] = state.info.id
        hatCongdtsUpdate['action'] = params.action
        apiUpdateInfo(
          hatCongdtsUpdate,
          (result) => {
            commit('update_congdts_in_hat', {
              id: hatCongdtsUpdate.hatId,
              cong_doan_tu_sis: result.data.data.results,
            })
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
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
      } else {
        _.forEach(params.hat.cong_doan_tu_sis, (item) => {
          if (
            fnCheckProp(item, 'id') &&
                        item.id == hatCongdtsUpdate.id
          ) {
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
            commit(
              'update_dropdown_congdts_in_hat',
              hatCongdtsUpdate
            )
          }
        })
      }
    },
    addHatXuGiaoPhan({ commit, }, params) {
      let giaoHat = params.giaoHat
      giaoHat.giao_xus.push({
        id: uuidv4(),
        isCheck: false,
        isEdit: 0,
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
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_XU_LIST(
      { dispatch, commit, state, },
      params
    ) {
      let hatXuUpdate = params.hatXu
      if (
        fnCheckProp(params, 'action') &&
                params.action === 'create.update.hat.xu.db'
      ) {
        dispatch(ACTION_SET_LOADING, true)
        //implement
        hatXuUpdate['giao_phan_id'] = state.info.id
        hatXuUpdate['action'] = params.action
        apiUpdateInfo(
          hatXuUpdate,
          (result) => {
            commit('update_giao_xu_in_hat', {
              id: hatXuUpdate.hatId,
              giao_xus: result.data.data.results,
            })
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
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
      } else {
        _.forEach(params.hat.giao_xus, (item) => {
          if (fnCheckProp(item, 'id') && item.id == hatXuUpdate.id) {
            hatXuUpdate = _.update(
              item,
              'giao_xu_id',
              (giao_xu_id) => {
                giao_xu_id = params.hatXuInfo.id

                return giao_xu_id
              }
            )
            hatXuUpdate = _.update(
              item,
              'hatXuName',
              (hatXuName) => {
                hatXuName = params.hatXuInfo.name

                return hatXuName
              }
            )
            commit('update_dropdown_giao_xu_in_hat', hatXuUpdate)
          }
        })
      }
    },
    addHatGiaoPhan({ commit, state, }) {
      let giaoHats = state.info.giao_phan_hats
      giaoHats.push({
        id: uuidv4(),
        isCheck: false,
        isEdit: 0,
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
    checkAllHat({ state, }, check) {
      _.forEach(state.info.giao_phan_hats, (item) => {
        _.update(item, 'isCheck', (isCheck) => {
          isCheck = check

          return isCheck
        })
      })
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST(
      { dispatch, commit, state, },
      params
    ) {
      let hat = params.hat
      let giaoHats = state.info.giao_phan_hats
      if (
        fnCheckProp(params, 'action') &&
                params.action === 'create.update.hat.db'
      ) {
        dispatch(ACTION_SET_LOADING, true)
        //implement
        hat['giao_phan_id'] = state.info.id
        hat['action'] = params.action
        apiUpdateInfo(
          hat,
          (result) => {
            commit(
              'update_hat_in_giao_phan',
              result.data.data.results
            )
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
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
      } else {
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
      }
    },
    addDongGiaoPhan({ commit, state, }) {
      let dongs = state.info.giao_phan_dongs
      dongs.push({
        id: uuidv4(),
        isCheck: false,
        isEdit: 0,
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
    checkAllDong({ state, }, check) {
      _.forEach(state.info.giao_phan_dongs, (item) => {
        _.update(item, 'isCheck', (isCheck) => {
          isCheck = check

          return isCheck
        })
      })
    },
    ACTION_UPDATE_DROPDOWN_DONG_LIST({ dispatch, commit, state, }, params) {
      let dong = params.dong
      let dongs = state.info.giao_phan_dongs
      if (
        fnCheckProp(params, 'action') &&
                params.action === 'create.update.dong.db'
      ) {
        dispatch(ACTION_SET_LOADING, true)
        //implement
        dong['giao_phan_id'] = state.info.id
        dong['action'] = params.action
        apiUpdateInfo(
          dong,
          (result) => {
            commit(
              'update_dong_in_giao_phan',
              result.data.data.results
            )
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
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
      } else {
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
      }
    },
    addCoSoGiaoPhan({ commit, state, }) {
      let cosos = state.info.giao_phan_cosos
      cosos.push({
        id: uuidv4(),
        isCheck: false,
        isEdit: 0,
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
    checkAllCoSo({ state, }, check) {
      _.forEach(state.info.giao_phan_cosos, (item) => {
        _.update(item, 'isCheck', (isCheck) => {
          isCheck = check

          return isCheck
        })
      })
    },
    ACTION_UPDATE_DROPDOWN_COSO_LIST({ dispatch, commit, state, }, params) {
      let coso = params.coso
      let cosos = state.info.giao_phan_cosos
      if (
        fnCheckProp(params, 'action') &&
                params.action === 'create.update.co.so.db'
      ) {
        dispatch(ACTION_SET_LOADING, true)
        //implement
        coso['giao_phan_id'] = state.info.id
        coso['action'] = params.action
        apiUpdateInfo(
          coso,
          (result) => {
            commit(
              'update_coso_in_giao_phan',
              result.data.data.results
            )
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
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
      } else {
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
      }
    },
    addBanChuyenTrachGiaoPhan({ commit, state, }) {
      let banChuyenTrachs = state.info.giao_phan_banchuyentrachs
      banChuyenTrachs.push({
        id: uuidv4(),
        isCheck: false,
        isEdit: 0,
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
    checkAllBanChuyenTrach({ state, }, check) {
      _.forEach(state.info.giao_phan_banchuyentrachs, (item) => {
        _.update(item, 'isCheck', (isCheck) => {
          isCheck = check

          return isCheck
        })
      })
    },
    ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST(
      { dispatch, commit, state, },
      params
    ) {
      let banChuyenTrach = params.banChuyenTrach
      let banChuyenTrachs = state.info.giao_phan_banchuyentrachs
      if (
        fnCheckProp(params, 'action') &&
                params.action === 'create.update.ban.chuyen.trach.db'
      ) {
        dispatch(ACTION_SET_LOADING, true)
        //implement
        banChuyenTrach['giao_phan_id'] = state.info.id
        banChuyenTrach['action'] = params.action
        apiUpdateInfo(
          banChuyenTrach,
          (result) => {
            commit(
              'update_banchuyentrach_in_giao_phan',
              result.data.data.results
            )
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
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
      } else {
        _.forEach(banChuyenTrachs, (item) => {
          if (
            fnCheckProp(item, 'id') &&
                        item.id == params.banChuyenTrach.id
          ) {
            banChuyenTrach = _.update(
              item,
              'ban_chuyen_trach_id',
              (ban_chuyen_trach_id) => {
                ban_chuyen_trach_id =
                                    params.banChuyenTrachInfo.id

                return ban_chuyen_trach_id
              }
            )
            banChuyenTrach = _.update(
              item,
              'banChuyenTrachName',
              (banChuyenTrachName) => {
                banChuyenTrachName =
                                    params.banChuyenTrachInfo.name

                return banChuyenTrachName
              }
            )
            commit(
              'update_dropdown_banchuyentrach_in_giao_phan',
              banChuyenTrach
            )
          }
        })
      }
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_SET_LOADING, isLoading)
    },
    [ACTION_INSERT_INFO]({ dispatch, commit, }, info) {
      apiUpdateInfo(
        info,
        (result) => {
          if (result) {
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            dispatch(ACTION_GET_INFO_BY_ID, info.id)
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
    [ACTION_INSERT_INFO_BACK]({ dispatch, commit, }, info) {
      apiUpdateInfo(
        info,
        (result) => {
          if (result) {
            commit(
              INFOS_MODAL_INSERT_INFO_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
            dispatch('MODULE_GIAO_PHAN_ACTION_RELOAD_INFO_LIST', 'page', {
              root: true,
            })
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_INSERT_INFO_FAILED,
            AppConfig.comUpdateNoFail
          )
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },
    [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetInfoById(
        infoId,
        (result) => {
          commit('GIAO_PHANS_SET_INFO', result.data.giaophan)
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(SET_ERROR, Object.values(errors))
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
