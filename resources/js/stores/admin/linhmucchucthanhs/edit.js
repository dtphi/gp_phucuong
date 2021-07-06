import AppConfig from 'api@admin/constants/app-config';
import { v4 as uuidv4 } from 'uuid';
import {
  apiGetInfoById,
  apiUpdateInfo
} from 'api@admin/linhmucchucthanh';
import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_SUCCESS,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
  INFOS_FORM_SET_MAIN_IMAGE
} from '../types/mutation-types';
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SET_IMAGE,
} from '../types/action-types';
import {
  config
} from '@app/api/admin/config';

const defaultState = () => {
  return {
    styleCss: '',
    isExistInfo: config.existStatus.checking,
    info: {
      image: '',
      ten: '',
      ten_thanh_id: null,
      ngay_thang_nam_sinh: null,
      noi_sinh: '',
      giao_xu_id: null,
      ho_ten_cha: '',
      ho_ten_me: '',
      noi_rua_toi: '',
      ngay_rua_toi: null,
      noi_them_suc: '',
      ngay_them_suc:null,
      tieu_chung_vien:null,
      ngay_tieu_chung_vien:null,
      dai_chung_vien:null,
      ngay_dai_chung_vien:null,
      chucthanh_id:null,
      so_cmnd:null,
      noicap_cmnd:'',
      ngay_cap_cmnd:null,
      trieu_dong:null,
      ten_dong_id:'',
      ngay_trieu_dong:null,
      ngay_khan:null,
      ngay_rip:null,
      rip_giao_xu_id:null,
      rip_ghi_chu:'',
      ghi_chu: '',
      active: 1,

      bang_caps: [],
      chuc_thanhs: [],
      thuyen_chuyens: [],
      van_thus: [],
    },
    isImgChange: false,
    listCategorysDisplay: [],
    listRelatedsDisplay: [],
    infoId: 0,
    loading: false,
    updateSuccess: false,
    errors: []
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
      if (state.isExistInfo !== config.existStatus.checking ||
        state.isExistInfo !== config.existStatus.exist) {
        return false;
      }

      return true;
    }
  },

  mutations: {

    [INFOS_MODAL_SET_INFO_ID](state, payload) {
      if (payload) {
        state.infoId = payload;
        state.isExistInfo = config.existStatus.exist;
      }
    },

    [INFOS_MODAL_SET_INFO_ID_FAILED](state, payload) {
      state.errors = payload
    },

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

    [INFOS_MODAL_SET_ERROR](state, payload) {
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

    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload;
      state.isImgChange = true;
    }
  },

  actions: {
    [ACTION_SHOW_MODAL_EDIT]({
      dispatch,
    }, infoId) {
      dispatch(ACTION_GET_INFO_BY_ID, infoId);
    },

    [ACTION_GET_INFO_BY_ID]({
      dispatch,
      commit
    }, infoId) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetInfoById(
        infoId,
        (result) => {
          commit(INFOS_MODAL_SET_INFO_ID, infoId);
          commit(INFOS_MODAL_SET_INFO, result.data);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_SET_INFO_ID_FAILED, Object.values(errors))

          dispatch(ACTION_SET_LOADING, false);
        }
      );
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading);
    },

    [ACTION_UPDATE_INFO]({
      dispatch,
      commit
    }, info) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '');
      apiUpdateInfo(info,
        (result) => {
          commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, AppConfig.comUpdateNoSuccess);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_UPDATE_INFO_FAILED, AppConfig.comUpdateNoFail)

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({
      commit
    }, values) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values);
    },

    [ACTION_SET_IMAGE]({
      commit
    }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile);
    },
  }
}