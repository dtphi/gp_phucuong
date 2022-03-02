import AppConfig from 'api@admin/constants/app-config'
import { apiGetInfoGiaoXuById, apiUpdateInfo, apiUpdateGiaoXuThuyenChuyen, apiGetThuyenChuyenById} from 'api@admin/giaoxu'
import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
  INFOS_FORM_SET_MAIN_IMAGE,
	INFOS_MODAL_INSERT_INFO_FAILED,
	INFOS_MODAL_INSERT_INFO_SUCCESS,
} from '../types/mutation-types'
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_UPDATE_INFO,
  ACTION_UPDATE_INFO_BACK,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SET_IMAGE,
	ACTION_CHANGE_STATUS
} from '../types/action-types'
import { config, } from '@app/api/admin/config'
import { getField, updateField } from 'vuex-map-fields'

const defaultState = () => {
  return {
    styleCss: '',
    isExistInfo: config.existStatus.checking,
    info: {
      image: '',
      name: '',
      ngay_thanh_lap: null,
      date_available: null,
      dia_chi: '',
      dien_thoai: '',
      email: '',
      active: 1,
      dan_so: '',
      sp_tin_huu: '',
      gio_le: '',
      viet: null,
      latin: null,
      noi_dung: '',
      type: 'giaoxu',
      update_user: 0,
      giaohat_id: null,
      thuyen_chuyens: [],
    },
    thuyenChuyen: null,
    listGiaoHat: [],
    isGetInfoList: null,
    infoId: 0,
    loading: false,
    updateSuccess: false,
    errors: [],
    isImgChange: true,
		arr_thuyen_chuyens: [],
		update_thuyen_chuyen: {
			id: '',
			giao_xu_id: '',
			linh_muc_id: '',
			linhMucName: '',
			tenThanh: '',
			chuc_vu_id: '',
			chucvuName: '',
			label_from_date: '',
			label_to_date: '',
			from_date: '',
			to_date: ''
		},
		insertSuccess: false,
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
    updateSuccess(state) {
      return state.updateSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
    isNotExistValidate(state) {
      if (
        state.isExistInfo !== config.existStatus.checking ||
                state.isExistInfo !== config.existStatus.exist
      ) {
        return false
      }

      return true
    },
    isGiaoHat(state) {
      return state.listGiaoHat
    },
    getInfoField(state) {
      return getField(state.info)
    },
		arr_thuyen_chuyens(state) {
			return state.arr_thuyen_chuyens
		},
		update_thuyen_chuyen(state) {
			return state.update_thuyen_chuyen
		},
		insertSuccess(state) {
      return state.insertSuccess
    },
  },

  mutations: {
    [INFOS_MODAL_SET_INFO_ID](state, payload) {
      if (payload) {
        state.infoId = payload
        state.isExistInfo = config.existStatus.exist
      }
    },

    [INFOS_MODAL_SET_INFO_ID_FAILED](state, payload) {
      state.errors = payload
    },

    // INFO GIAO XU
    [INFOS_MODAL_SET_INFO](state, payload) {
      state.info = payload
    },

    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_UPDATE_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_UPDATE_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [SET_ERROR](state, payload) {
      state.errors = payload
    },

    [INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST](state, payload) {
      state.info.categorys = payload
    },

    [INFOS_FORM_ADD_INFO_TO_RELATED_LIST](state, payload) {
      state.info.relateds = payload
    },

    [INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST](state, payload) {
      state.listRelatedsDisplay = payload
    },
		[INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.insertSuccess = payload
    },
    INFO_GIAO_HAT(state, payload) {
      state.listGiaoHat = payload
    },
    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload
      state.isImgChange = true
    },
		[INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.insertSuccess = payload
    },
    updateInfoField(state, field) {
      return updateField(state.info, field)
    },
		set_arr_thuyen_chuyens(state, payload) {
			state.arr_thuyen_chuyens = payload
		},
		set_update_thuyen_chuyen(state, payload) {
			state.update_thuyen_chuyen = payload
		},
		remove_thuyen_chuyens(state, index) {
			state.arr_thuyen_chuyens.splice(index, 1)
		}
  },

  actions: {
    [ACTION_SHOW_MODAL_EDIT]({ dispatch, }, infoId) {
      dispatch(ACTION_GET_INFO_BY_ID, infoId)
    },

    // GET ID GIAO XU
    [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetInfoGiaoXuById(
        infoId,
        (result) => {
          commit(INFOS_MODAL_SET_INFO_ID, infoId)
          commit(INFOS_MODAL_SET_INFO, result.data.giaoxu)
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            INFOS_MODAL_SET_INFO_ID_FAILED,
            Object.values(errors)
          )
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading)
    },

    // UPDATE GIAO XU 
    [ACTION_UPDATE_INFO]({ commit, }, info) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '')
      apiUpdateInfo(
        info,
        (result) => {
          if (result) {
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_UPDATE_INFO_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_UPDATE_INFO_FAILED,
            AppConfig.comUpdateNoFail
          )
          commit(SET_ERROR, errors)
        }
      )
    },

    // UPDATE TO BACK
    [ACTION_UPDATE_INFO_BACK]({ dispatch, commit, }, info) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '')
      apiUpdateInfo(
        info,
        (result) => {
          if (result) {
            commit(SET_ERROR, [])
            commit(
              INFOS_MODAL_UPDATE_INFO_SUCCESS,
              AppConfig.comUpdateNoSuccess
            )
            dispatch(ACTION_GET_INFO_BY_ID, info.id)
            dispatch(
              'ACTION_RELOAD_GET_INFO_LIST_GIAO_XU',
              'page',
              {
                root: true,
              }
            )
          }
        },
        (errors) => {
          commit(
            INFOS_MODAL_UPDATE_INFO_FAILED,
            AppConfig.comUpdateNoFail
          )
          commit(SET_ERROR, errors)
          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },

		ACTION_GET_INFO_THUYEN_CHUYEN({commit}, infoId) {
      apiGetThuyenChuyenById(
        infoId,
        (response) => {
          commit('set_arr_thuyen_chuyens', response.data.results)
        },
        (errors) => {
          commit(SET_ERROR, Object.values(errors))
        }
      )
		},

		async addThuyenChuyen({ dispatch, commit, state, }, params) {
        let thuyenChuyen = params.data
        dispatch(ACTION_SET_LOADING, true)
        //implement
        thuyenChuyen['giaoxuId'] = params.giaoxuId	
        thuyenChuyen['action'] = params.action
        apiUpdateGiaoXuThuyenChuyen(
          thuyenChuyen,
          (response) => {
            commit('set_arr_thuyen_chuyens', response.data.data.results)
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
		},
		[ACTION_CHANGE_STATUS]({ commit, }, info) {
			info['giaoxuId'] = info.item.giao_xu_id
      apiUpdateGiaoXuThuyenChuyen(
        info,
        (result) => {
          if (result) {
            commit(SET_ERROR, [])
          }
        },
        (errors) => {
          commit(SET_ERROR, errors)
        }
      )
    },

		async updateActiveThuyenChuyen({ commit, state, dispatch }, info ) {
			dispatch(ACTION_CHANGE_STATUS, info)
    },
		removeThuyenChuyen({ commit }, info) {
			info['giaoxuId'] = info.id
			commit('remove_thuyen_chuyens', info.vitri)
			apiUpdateGiaoXuThuyenChuyen(
        info,
        (response) => {
				},
        (errors) => {}
      )
    },

		updateThuyenChuyen({ commit }, info) {
			info['giaoxuId'] = info.giaoxuId
			commit('set_update_thuyen_chuyen', info.data)
			apiUpdateGiaoXuThuyenChuyen(
        info,
        (response) => {
					commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, AppConfig.comUpdateNoSuccess);
				},
        (errors) => {}
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values)
    },
    [ACTION_SET_IMAGE]({ commit, }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
    },
  },
}
