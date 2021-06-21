import AppConfig from 'api@admin/constants/app-config';
import { v4 as uuidv4 } from 'uuid';
import {
  apiInsertInfo
} from 'api@admin/linhmuc';
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
  INFOS_FORM_SET_MAIN_IMAGE,
  INFOS_FORM_SET_DROPDOWN_RELATED_LIST,
  INFOS_FORM_GET_DROPDOWN_RELATED_SUCCESS,
  INFOS_FORM_GET_DROPDOWN_RELATED_FAILED,
  INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED,
} from '../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_ADD_INFO_TO_CATEGORY_LIST,
  ACTION_REMOVE_INFO_TO_CATEGORY_LIST,
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
      rip_giaoxu_id:null,
      rip_giaoxu_name: '',
      rip_ghi_chu:'',
      ghichu: '',
      active: 1,

      bang_caps: [],
      chuc_thanhs: [],
      thuyen_chuyens: [],
      van_thus: [],
    },
    isImgChange: true,
    listCategorysDisplay: [],
    listRelatedsDisplay: [],
    dropdownsRelateds: [],
    infoRelated: {
      information_id: 0,
      name: ''
    },
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
    update_dropdown_thuyen_chuyen(state, payload) {
      _.forEach(state.info.thuyen_chuyens, function(item, idx) {
        if (item.hasOwnProperty('id') && item.id == payload.id) {
          state.info.thuyen_chuyens[idx] = payload;
        }
      });
    },
    update_thuyen_chuyen(state, payload) {
      state.info.thuyen_chuyens = payload;
    },
    update_van_thu(state, payload) {
      state.info.van_thus = payload;
    },
    update_chuc_thanh(state, payload) {
      state.info.chuc_thanhs = payload;
    },
    update_bang_cap(state, payload) {
      state.info.bang_caps = payload;
    },
    [INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED](state, payload) {
      state.infoRelated = payload;
    },

    [INFOS_FORM_SET_DROPDOWN_RELATED_LIST](state, payload) {
      state.dropdownsRelateds = payload;
    },

    [INFOS_FORM_GET_DROPDOWN_RELATED_SUCCESS](state, payload) {

    },
    [INFOS_FORM_GET_DROPDOWN_RELATED_FAILED](state, payload) {

    },

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
    ACTION_UPDATE_DROPDOWN_DONG({state}, params) {
      state.info.ten_dong_id = params.dong.id;
      state.info.ten_dong_name = params.dong.name;
    },
    ACTION_UPDATE_DROPDOWN_RIP_GIAO_XU({state}, params) {
      state.info.rip_giaoxu_id = params.giaoXu.id;
      state.info.rip_giaoxu_name = params.giaoXu.name;
    },
    ACTION_UPDATE_DROPDOWN_GIAO_XU({state}, params) {
      state.info.giao_xu_id = params.giaoXu.id;
      state.info.giao_xu_name = params.giaoXu.name;
    },
    ACTION_UPDATE_DROPDOWN_TEN_THANH_LIST({state}, params) {
      state.info.ten_thanh_id = params.tenThanh.id;
      state.info.ten_thanh_name = params.tenThanh.name;
    },
    addBangCaps({state, commit}, params) {
      let bangCaps = state.info.bang_caps;
      bangCaps.push({
        id: uuidv4(),
        name: '',
        type: 0,
        ghichu: '',
        active: 1
      });
      commit('update_bang_cap', bangCaps);
    },
    removeBangCap({state}, params) {
      let bangCaps = state.info.bang_caps;
      const data = params.item;

      commit('update_bang_cap', _.remove(bangCaps, function(item) {
        return !(item.id == data.id);
      }))
    },

    addChucThanhs({commit, state}, params) {
      let chucThanhs = state.info.chuc_thanhs;
      chucThanhs.push({
        id: uuidv4(),
        chuc_thanh_id: 1,
        ngay_thang_nam_chuc_thanh: null,
        noi_thu_phong:'',
        nguoi_thu_phong:'',
        ghichu: '',
        active: 1
      });
      commit('update_chuc_thanh', chucThanhs);
    },
    removeChucThanh({commit, state}, params) {
      let chucThanhs = state.info.chuc_thanhs;
      const data = params.item;

      commit('update_chuc_thanh', _.remove(chucThanhs, function(item) {
        return !(item.id == data.id);
      }));
    },

    addVanThus({commit, state}, params) {
      let vanThus = state.info.van_thus;
      vanThus.push({
        id: uuidv4(),
        parent_id: 0,
        title: null,
        type:'',
        ghichu: '',
        active: 1
      });
      commit('update_van_thu', vanThus);
    },
    removeVanThu({commit, state}, params) {
      let vanThus = state.info.van_thus;
      const data = params.item;

      commit('update_van_thu', _.remove(vanThus, function(item) {
        return !(item.id == data.id);
      }));
    },

    ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_BAN_CHUYEN_TRACH({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.banchuyentrachName = params.banChuyenTrach.name;
      thuyenChuyen.banchuyentrach_id = params.banChuyenTrach.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    ACTION_UPDATE_DROPDOWN_THUYEN_CHUYEN_DONG({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.dongName = params.dong.name;
      thuyenChuyen.dong_id = params.dong.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    ACTION_UPDATE_DROPDOWN_CO_SO_GIAO_PHAN({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.cosogpName = params.coso.name;
      thuyenChuyen.cosogp_id = params.coso.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    ACTION_UPDATE_DROPDOWN_FROM_GIAO_XU({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.fromgiaoxuName = params.giaoXu.name;
      thuyenChuyen.fromgiaoxu_id = params.giaoXu.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    ACTION_UPDATE_DROPDOWN_TO_GIAO_XU({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.giaoxuName = params.giaoXu.name;
      thuyenChuyen.giaoxu_id = params.giaoXu.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    ACTION_UPDATE_DROPDOWN_FROM_CHUC_VU({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.fromchucvuName = params.chucVu.name;
      thuyenChuyen.fromchucvu_id = params.chucVu.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    ACTION_UPDATE_DROPDOWN_TO_CHUC_VU({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.chucvuName = params.chucVu.name;
      thuyenChuyen.chucvu_id = params.chucVu.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    ACTION_UPDATE_DROPDOWN_FROM_DUC_CHA({commit, state}, params) {
      let thuyenChuyen = params.thuyenChuyen;

      thuyenChuyen.ducchaName = params.ducCha.name;
      thuyenChuyen.duccha_id = params.ducCha.id;

      commit('update_dropdown_thuyen_chuyen', thuyenChuyen)
    },
    addThuyenChuyen({commit, state}, params) {
      let thuyenChuyens = state.info.thuyen_chuyens;
      thuyenChuyens.push({
        id: uuidv4(),
        fromgiaoxu_id: null,
        fromgiaoxuName: '',
        fromchucvu_id: null,
        fromchucvuName: '',
        from_date: null,
        duccha_id: null,
        ducchaName: '',
        to_date: null,
        chucvu_id: null,
        chucvuName: '',
        giaoxu_id: null,
        giaoxuName: '',
        cosogp_id: null,
        cosogpName: '',
        dong_id: null,
        dongName: '',
        banchuyentrach_id: null,
        banchuyentrachName: '',
        duhoc: null,
        quocgia: null,
        ghichu: '',
        active: 1
      });
      commit('update_thuyen_chuyen', thuyenChuyens);
    },
    removeThuyenChuyen({commit, state}, params) {
      let thuyenChuyens = state.info.thuyen_chuyens;
      const data = params.item;

      commit('update_thuyen_chuyen', _.remove(thuyenChuyens, function(item) {
        return !(item.id == data.id);
      }));
    },

    update_special_carousel({state}, specialCarousel) {
      state.info.special_carousels = specialCarousel;
    },

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

          dispatch(ACTION_RELOAD_GET_INFO_LIST, 'page', {
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
    }
  }
}