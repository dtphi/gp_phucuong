import AppConfig from 'api@admin/constants/app-config';
import {
  apiInsertInfo
} from 'api@admin/linhmucchucthanh';
import {
  MODULE_MODULE_CHUC_THANH,
} from '../types/module-types';
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_SET_MAIN_IMAGE,
} from '../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE,
} from '../types/action-types';

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
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
      ngay_them_suc:null,
      tieu_chung_vien:null,
      ngay_tieu_chung_vien:null,
      dai_chung_vien:null,
      ngay_dai_chung_vien:null,
      so_cmnd:null,
      noicap_cmnd:'',
      ngay_cap_cmnd:null,
      trieu_dong:null,
      ten_dong_id:'',
      ten_dong_name: '',
      ngay_trieu_dong:null,
      ngay_khan:null,
      ngay_rip:null,
      rip_giao_xu_id:null,
      rip_giaoxu_name: '',
      rip_ghi_chu:'',
      ghi_chu: '',
      active: 1,

      bang_caps: [],
      chuc_thanhs: [],
      thuyen_chuyens: [],
      van_thus: [],
    },
    isImgChange: true,
    infoId: 0,
    loading: false,
    insertSuccess: false,
    errors: []
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
    }
  },

  mutations: {
    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
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

    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload;
      state.isImgChange = true;
    }
  },

  actions: {
    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading);
    },

    [ACTION_INSERT_INFO]({
      dispatch,
      commit
    }, info) {
      apiInsertInfo(
        info,
        (result) => {
          commit(INFOS_MODAL_INSERT_INFO_SUCCESS, AppConfig.comInsertNoSuccess);
          commit(INFOS_MODAL_SET_ERROR, []);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_INSERT_INFO_FAILED, AppConfig.comInsertNoFail);
          commit(INFOS_MODAL_SET_ERROR, errors);

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_INSERT_INFO_BACK]({
      dispatch,
      commit
    }, info) {
      apiInsertInfo(
        info,
        (result) => {
          commit(INFOS_MODAL_INSERT_INFO_SUCCESS, AppConfig.comInsertNoSuccess);

          dispatch(MODULE_MODULE_CHUC_THANH + '_' + ACTION_RELOAD_GET_INFO_LIST, 'page', {
            root: true
          });
        },
        (errors) => {
          commit(INFOS_MODAL_INSERT_INFO_FAILED, AppConfig.comInsertNoFail);
          commit(INFOS_MODAL_SET_ERROR, errors);

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_SET_IMAGE]({
      commit
    }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile);
    }
  }
}