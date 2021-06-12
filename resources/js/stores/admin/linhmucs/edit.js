import AppConfig from 'api@admin/constants/app-config';
import { v4 as uuidv4 } from 'uuid';
import {
  apiGetInfoById,
  apiUpdateInfo
} from 'api@admin/information';
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
  INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST,
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
  ACTION_ADD_INFO_TO_CATEGORY_LIST,
  ACTION_REMOVE_INFO_TO_CATEGORY_LIST,
  ACTION_SET_IMAGE,
  ACTION_ADD_INFO_TO_RELATED_LIST,
  ACTION_REMOVE_INFO_TO_RELATED_LIST,
} from '../types/action-types';
import {
  config
} from '@app/api/admin/config';

const defaultState = () => {
  return {
    styleCss: '',
    isExistInfo: config.existStatus.checking,
    info: {
      image: {
        basename: "",
        dirname: "",
        extension: "",
        filename: "",
        path: "",
        size: 0,
        thumb: "",
        timestamp: null,
        type: null
      },
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
      rip_giaoxu_id:null,
      rip_ghi_chu:'',
      ghichu: '',
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

    [INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST](state, payload) {
      state.listCategorysDisplay = payload
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
    addBangCaps({state}, params) {
      state.info.bang_caps.push({
        id: uuidv4(),
        name: '',
        type: 0,
        ghichu: '',
        active: 1
      })
    },
    removeBangCap({state}, params) {
      let bangCaps = state.info.bang_caps;
      const data = params.item;

      state.info.bang_caps = _.remove(bangCaps, function(item) {
        return !(item.id == data.id);
      })
    },
    addChucThanhs({state}, params) {
      state.info.chuc_thanhs.push({
        id: uuidv4(),
        chuc_thanh_id: 1,
        ngay_thang_nam_chuc_thanh: null,
        noi_thu_phong:'',
        nguoi_thu_phong:'',
        ghichu: '',
        active: 1
      })
    },
    removeChucThanh({state}, params) {
      let chuc_thanhs = state.info.chuc_thanhs;
      const data = params.item;

      state.info.chuc_thanhs = _.remove(chuc_thanhs, function(item) {
        return !(item.id == data.id);
      })
    },
    addVanThus({state}, params) {
      state.info.van_thus.push({
        id: uuidv4(),
        parent_id: 0,
        title: null,
        type:'',
        ghichu: '',
        active: 1
      })
    },
    removeVanThu({state}, params) {
      let van_thus = state.info.van_thus;
      const data = params.item;

      state.info.van_thus = _.remove(van_thus, function(item) {
        return !(item.id == data.id);
      })
    },
    addThuyenChuyen({state}, params) {
      state.info.thuyen_chuyens.push({
        id: uuidv4(),
        fromgiaoxu_id: null,
        fromchucvu_id: null,
        from_date: null,
        duccha_id: null,
        to_date: null,
        chucvu_id: null,
        giaoxu_id: null,
        cosogp_id: null,
        dong_id: null,
        banchuyentrach_id: null,
        duhoc: null,
        quocgia: null,
        ghichu: '',
        active: 1
      })
    },
    removeThuyenChuyen({state}, params) {
      let thuyen_chuyens = state.info.thuyen_chuyens;
      const data = params.item;

      state.info.thuyen_chuyens = _.remove(thuyen_chuyens, function(item) {
        return !(item.id == data.id);
      })
    },
    update_special_carousel({state}, specialCarousel) {
      state.info.special_carousels = specialCarousel;
    },

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
          commit(INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST, result.data.category_display_list);

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

    [ACTION_ADD_INFO_TO_CATEGORY_LIST]({
      commit,
      state
    }, category) {
      const categorys = state.info.categorys;
      const listCateShow = state.listCategorysDisplay;

      if (typeof category === "object" && Object.keys(category).length) {
        if ((categorys.indexOf(category.category_id) === -1) && (parseInt(category.category_id) > 0)) {
          categorys.push(category.category_id);
          listCateShow.push(category);
        }
      }

      commit(INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST, categorys);
      commit(INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST, listCateShow);
    },

    [ACTION_REMOVE_INFO_TO_CATEGORY_LIST]({
      state,
      commit
    }, category) {
      const categorys = state.info.categorys;
      const listCateShow = state.listCategorysDisplay;

      commit(INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST, _.remove(categorys, function(cateId) {
        return (cateId - category.category_id !== 0);
      }));
      commit(INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST, _.remove(listCateShow, function(item) {
        return (item.category_id - category.category_id !== 0);
      }));
    },

    [ACTION_SET_IMAGE]({
      commit
    }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile);
    },

    [ACTION_ADD_INFO_TO_RELATED_LIST]() {
      const relateds = state.info.relateds;
      const listRelatedShow = state.listRelatedsDisplay;

      if (typeof related === "object" && Object.keys(related).length) {
        if ((relateds.indexOf(related.information_id) === -1) && (parseInt(related.information_id) > 0)) {
          relateds.push(related.information_id);
          listRelatedShow.push(related);
        }
      }

      commit(INFOS_FORM_ADD_INFO_TO_RELATED_LIST, relateds);
      commit(INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST, listRelatedShow);
    },

    [ACTION_REMOVE_INFO_TO_RELATED_LIST]() {
      const relateds = state.info.relateds;
      const listRelatedShow = state.listRelatedsDisplay;

      commit(INFOS_FORM_ADD_INFO_TO_RELATED_LIST, _.remove(relateds, function(infoId) {
        return (infoId - related.information_id !== 0);
      }));
      commit(INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST, _.remove(listRelatedShow, function(item) {
        return (item.information_id - related.information_id !== 0);
      }));
    },
  }
}