import AppConfig from 'api@admin/constants/app-config';
import { v4 as uuidv4 } from 'uuid';
import {
  apiInsertInfo,
} from 'api@admin/giaophan';
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
import _ from 'lodash';

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    info: {
      image: {
        basename: "",
        dirname: "",
        extension: "",
        filename: "",
        path: "",
        size: 0,
        thumb: "", //url thumb
        timestamp: null,
        type: null
      },
      name: '',
      khaiquat: '',
      sort_id: '',
      active: 1,
      updateuser: '',

      giao_phan_hats: [],
      giao_phan_dongs: [],
      giao_phan_cosos: [],
      giao_phan_banchuyentrachs: [],
      giao_phan_hat_xu_diems: []
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
    giaoXus(state) {
      let giaoXus = [];
      _.forEach(state.info.giao_phan_hats, function(item){
        giaoXus = _.concat(giaoXus, item.giao_xus);
      });

      return giaoXus;
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
    update_giao_xu_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (item.hasOwnProperty('id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx].giao_xus = payload.giao_xus;
        }
      });
    },
    update_dropdown_giao_xu_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (item.hasOwnProperty('id') && item.hasOwnProperty('giao_xus') && item.id == payload.hatId) {
          _.forEach(item.giao_xus, function(gx, index) {
            if (gx.hasOwnProperty('id') && gx.id == payload.id) {
              state.info.giao_phan_hats[idx].giao_xus[index] = payload;
            }
          })
        }
      });
    },
    
    update_congdts_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (item.hasOwnProperty('id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx].cong_doan_tu_sis = payload.cong_doan_tu_sis;
        }
      });
    },
    update_dropdown_congdts_in_hat(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (item.hasOwnProperty('id') && item.hasOwnProperty('cong_doan_tu_sis') && item.id == payload.hatId) {
          _.forEach(item.cong_doan_tu_sis, function(cdts, index) {
            if (cdts.hasOwnProperty('id') && cdts.id == payload.id) {
              state.info.giao_phan_hats[idx].cong_doan_tu_sis[index] = payload;
            }
          })
        }
      });
    },

    update_hat_in_giao_phan(state, payload) {
      state.info.giao_phan_hats = payload;
    },
    update_dropdown_hat_in_giao_phan(state, payload) {
      _.forEach(state.info.giao_phan_hats, function(item, idx) {
        if (item.hasOwnProperty('id') && item.id == payload.id) {
          state.info.giao_phan_hats[idx] = payload;
        }
      });
    },

    update_dong_in_giao_phan(state, payload) {
      state.info.giao_phan_dongs  = payload;
    },
    update_dropdown_dong_in_giao_phan(state, payload) {
      _.forEach(state.info.giao_phan_dongs, function(item, idx) {
        if (item.hasOwnProperty('id') && item.id == payload.id) {
          state.info.giao_phan_dongs[idx] = payload;
        }
      });
    },

    update_coso_in_giao_phan(state, payload) {
      state.info.giao_phan_cosos  = payload;
    },
    update_dropdown_coso_in_giao_phan(state, payload) {
      _.forEach(state.info.giao_phan_cosos, function(item, idx) {
        if (item.hasOwnProperty('id') && item.id == payload.id) {
          state.info.giao_phan_cosos[idx] = payload;
        }
      });
    },

    update_banchuyentrach_in_giao_phan(state, payload) {
      state.info.giao_phan_banchuyentrachs  = payload;
    },
    update_dropdown_banchuyentrach_in_giao_phan(state, payload) {
      _.forEach(state.info.giao_phan_banchuyentrachs, function(item, idx) {
        if (item.hasOwnProperty('id') && item.id == payload.id) {
          state.info.giao_phan_banchuyentrachs[idx] = payload;
        }
      });
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
    addHatCongDoanTuSiGiaoPhan({commit}, params) {
      let giaoHat = params.giaoHat;
      giaoHat.cong_doan_tu_sis.push({
        id: uuidv4(),
        hatId: giaoHat.id,
        giao_hat_id: giaoHat.giao_hat_id,
        cong_doan_tu_si_id: null,
        hatCongDtsName: '',
        active: 1
      });
      
      commit('update_congdts_in_hat', giaoHat);
    },
    removeHatCongDoanTuSiGiaoPhan({commit}, params) {
      let giaoHat = params.giaoHat;
      let congDts = params.giaoHat.cong_doan_tu_sis;
      let congDtsRm = params.congDoanTuSi;

      giaoHat.cong_doan_tu_sis = _.remove(congDts, function(item) {
        return !((item.id == congDtsRm.id) && (item.hatId == congDtsRm.hatId));
      });

      commit('update_congdts_in_hat', giaoHat);
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_CONGDTS_LIST({commit}, params) {
      let hatCongdtsUpdate = params.hatCongDts;

      _.forEach(params.hat.cong_doan_tu_sis, function(item) {
        if (item.hasOwnProperty('id') && (item.id == hatCongdtsUpdate.id) ) {
          hatCongdtsUpdate = _.update(item, 'cong_doan_tu_si_id', function(cong_doan_tu_si_id) {
              return cong_doan_tu_si_id = params.hatCongDtsInfo.id;
          })
          hatCongdtsUpdate =  _.update(item, 'hatCongDtsName', function(hatCongDtsName) {
            return hatCongDtsName = params.hatCongDtsInfo.name;
          });

          commit('update_dropdown_congdts_in_hat', hatCongdtsUpdate);
        }
      });
    },
    addHatXuGiaoPhan({commit}, params) {
      let giaoHat = params.giaoHat;
      giaoHat.giao_xus.push({
        id: uuidv4(),
        hatId: giaoHat.id,
        giao_hat_id: giaoHat.giao_hat_id,
        giao_xu_id: null,
        hatXuName: '',
        active: 1,
        giao_xu_diems: []
      });
      
      commit('update_giao_xu_in_hat', giaoHat);
    },
    removeHatXuGiaoPhan({commit}, params) {
      let giaoHat = params.giaoHat;
      let giaoXus = params.giaoHat.giao_xus;
      let giaoXuRm = params.giaoXu;

      giaoHat.giao_xus = _.remove(giaoXus, function(item) {
        return !((item.id == giaoXuRm.id) && (item.hatId == giaoXuRm.hatId));
      });

      commit('update_giao_xu_in_hat', giaoHat);
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_XU_LIST({commit}, params) {
      let hatXuUpdate = params.hatXu;

      _.forEach(params.hat.giao_xus, function(item) {
        if (item.hasOwnProperty('id') && (item.id == hatXuUpdate.id) ) {
            hatXuUpdate = _.update(item, 'giao_xu_id', function(giao_xu_id) {
                return giao_xu_id = params.hatXuInfo.id;
            })
            hatXuUpdate =  _.update(item, 'hatXuName', function(hatXuName) {
              return hatXuName = params.hatXuInfo.name;
            });

            commit('update_dropdown_giao_xu_in_hat', hatXuUpdate);
        }
      });
    },
    addHatGiaoPhan({commit, state}, params) {
      let giaoHats = state.info.giao_phan_hats;
      giaoHats.push({
        id: uuidv4(),
        giao_hat_id: null,
        hatName: '',
        active: 1,
        giao_xus: [],
        cong_doan_tu_sis: []
      });
      commit('update_hat_in_giao_phan', giaoHats)
    },
    removeHatGiaoPhan({commit, state}, params) {
      let giaoPhanHats = state.info.giao_phan_hats;
      const data = params.item;

      giaoPhanHats = _.remove(giaoPhanHats, function(item) {
        return !(item.id == data.id);
      })

      commit('update_hat_in_giao_phan', giaoPhanHats)
    },
    ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST({commit, state}, params) {
      let hat = params.hat;
      let giaoHats = state.info.giao_phan_hats;

      _.forEach(giaoHats, function(item) {
        if (item.hasOwnProperty('id') && (item.id == params.hat.id) ) {
            hat = _.update(item, 'giao_hat_id', function(giao_hat_id) {
                return giao_hat_id = params.hatInfo.id;
            });
            hat = _.update(item, 'hatName', function(hatName) {
                return hatName = params.hatInfo.name;
            });

            commit('update_dropdown_hat_in_giao_phan', hat);
        }
      });
    },
    addDongGiaoPhan({commit, state}, params) {
      let dongs = state.info.giao_phan_dongs;
      dongs.push({
        id: uuidv4(),
        dong_id: null,
        dongName: '',
        active: 1
      });
      commit('update_dong_in_giao_phan', dongs);
    },
    removeDongGiaoPhan({commit, state}, params) {
      let giaoPhanDongs = state.info.giao_phan_dongs;
      const data = params.item;

      giaoPhanDongs = _.remove(giaoPhanDongs, function(item) {
        return !(item.id == data.id);
      })

      commit('update_dong_in_giao_phan', giaoPhanDongs);
    },
    ACTION_UPDATE_DROPDOWN_DONG_LIST({commit, state}, params) {
      let dong = params.dong;
      let dongs = state.info.giao_phan_dongs;

      _.forEach(dongs, function(item) {
        if (item.hasOwnProperty('id') && (item.id == params.dong.id) ) {
            dong = _.update(item, 'dong_id', function(dong_id) {
                return dong_id = params.dongInfo.id;
            });
            dong = _.update(item, 'dongName', function(dongName) {
                return dongName = params.dongInfo.name;
            });

            commit('update_dropdown_dong_in_giao_phan', dong);
        }
      });
    },
    addCoSoGiaoPhan({commit, state}, params) {
      let cosos = state.info.giao_phan_cosos;
      cosos.push({
        id: uuidv4(),
        co_so_giao_phan_id: null,
        cosoName: '',
        active: 1
      });
      commit('update_coso_in_giao_phan', cosos);
    },
    removeCoSoGiaoPhan({commit, state}, params) {
      let giaoPhanCosos = state.info.giao_phan_cosos;
      const data = params.item;

      giaoPhanCosos = _.remove(giaoPhanCosos, function(item) {
        return !(item.id == data.id);
      })

      commit('update_coso_in_giao_phan', giaoPhanCosos);
    },
    ACTION_UPDATE_DROPDOWN_COSO_LIST({commit, state}, params) {
      let coso = params.coso;
      let cosos = state.info.giao_phan_cosos;

      _.forEach(cosos, function(item) {
        if (item.hasOwnProperty('id') && (item.id == params.coso.id) ) {
            coso = _.update(item, 'co_so_giao_phan_id', function(co_so_giao_phan_id) {
                return co_so_giao_phan_id = params.cosoInfo.id;
            });
            coso = _.update(item, 'cosoName', function(cosoName) {
                return cosoName = params.cosoInfo.name;
            });

            commit('update_dropdown_coso_in_giao_phan', coso);
        }
      });
    },
    addBanChuyenTrachGiaoPhan({commit, state}, params) {
      let banChuyenTrachs = state.info.giao_phan_banchuyentrachs;
      banChuyenTrachs.push({
        id: uuidv4(),
        ban_chuyen_trach_id: null,
        banChuyenTrachName: '',
        active: 1
      });
      commit('update_banchuyentrach_in_giao_phan', banChuyenTrachs);
    },
    removeBanChuyenTrachGiaoPhan({commit, state}, params) {
      let giaoPhanBanChuyenTrachs = state.info.giao_phan_banchuyentrachs;
      const data = params.item;

      giaoPhanBanChuyenTrachs = _.remove(giaoPhanBanChuyenTrachs, function(item) {
        return !(item.id == data.id);
      })

      commit('update_banchuyentrach_in_giao_phan', giaoPhanBanChuyenTrachs);
    },
    ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST({commit, state}, params) {
      let banChuyenTrach = params.banChuyenTrach;
      let banChuyenTrachs = state.info.giao_phan_banchuyentrachs;

      _.forEach(banChuyenTrachs, function(item) {
        if (item.hasOwnProperty('id') && (item.id == params.banChuyenTrach.id) ) {
          banChuyenTrach = _.update(item, 'ban_chuyen_trach_id', function(ban_chuyen_trach_id) {
                return ban_chuyen_trach_id = params.banChuyenTrachInfo.id;
            });
            banChuyenTrach = _.update(item, 'banChuyenTrachName', function(banChuyenTrachName) {
                return banChuyenTrachName = params.banChuyenTrachInfo.name;
            });

            commit('update_dropdown_banchuyentrach_in_giao_phan', banChuyenTrach);
        }
      });
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
    },
  }
}