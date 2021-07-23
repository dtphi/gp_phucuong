import CategoryIconSideBar from './category_icon_side_bars';
import CategoryLeftSideBar from './category_left_side_bars';
import HomeBanner from './home_banners';
import ThongBao from './thong_baos';
import LoiChua from './loi_chuas';
import TinGiaoHoi from './tin_giao_hois';
import TinGiaoHoiVietNam from './tin_giao_hoi_viet_nams';
import TinGiaoPhan from './tin_giao_phans';
import VanKien from './van_kiens';
import NoiBat from './noi_bats';
import SpecialInfoCarousel from './special_info_carousels';

import AppConfig from 'api@admin/constants/app-config';
import {
  apiGetSettingByCode,
  apiInsertSetting
} from 'api@admin/setting';
import {
  INFOS_FORM_SET_MAIN_IMAGE,
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SET_KEYS_DATA,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  MODULE_UPDATE_SET_ERROR
} from '../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_SET_IMAGE,
  ACTION_GET_SETTING,
  ACTION_RESET_NOTIFICATION_INFO
} from '../types/action-types';

const defaultState = () => {
  return {
    logo_image: '',    
    banner_image: '',
    loading: false,
    updateSuccess: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    system(state) {
      return state
    },
    updateSuccess(state) {
      return state.updateSuccess
    }
  },
  mutations: {
    SYSTEMS_SET_LOGO_IMAGE(state, payload) {
      state.logo_image = payload;
    },
    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.banner_image = payload;
    },
    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
    },
    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      if (payload.hasOwnProperty('module_system_banners')) {
        state.banner_image = payload.module_system_banners.value.image;
      } 
      if (payload.hasOwnProperty('module_system_logos')) {
        state.logo_image = payload.module_system_logos.value;
      }
    },
    [MODULE_UPDATE_SETTING_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SETTING_FAILED](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SET_ERROR](state, payload) {
      state.errors = payload
    },
  },
  actions: {
    [ACTION_GET_SETTING]({
      dispatch,
      state,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetSettingByCode(
        "module_system",
        (res) => {
          if (Object.keys(res.data.results).length) {
            commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.results);

            dispatch(ACTION_SET_LOADING, false);
          } else {
            dispatch(ACTION_SET_LOADING, false);
          }
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false);
        }
      );
    },
    [ACTION_SET_IMAGE]({
      commit
    }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile);
    },
    ACTION_UPDATE_LOGO({ commit, state, dispatch }, logo) {
      if (logo) {
        commit("SYSTEMS_SET_LOGO_IMAGE", logo);
      } else {
        dispatch(ACTION_SET_LOADING, true);
        const data = {
          action: 'update',
          code: 'module_system',
          keys: [
            {
              key: 'module_system_logos',
              value:  state.logo_image,
              serialize: false
            }
          ]
        }

        apiInsertSetting(
          data,
          (result) => {
            commit(MODULE_UPDATE_SETTING_SUCCESS, AppConfig.comInsertNoSuccess);
            commit(MODULE_UPDATE_SET_ERROR, []);

            dispatch(ACTION_SET_LOADING, false);
          },
          (errors) => {
            commit(MODULE_UPDATE_SETTING_FAILED, AppConfig.comInsertNoFail);
            commit(MODULE_UPDATE_SET_ERROR, errors);

            dispatch(ACTION_SET_LOADING, false);
          }
        )
      }
    },
    ACTION_UPDATE_BANNER({ commit, state, dispatch }) {
      dispatch(ACTION_SET_LOADING, true);
      const data = {
        action: 'update',
        code: 'module_system',
        keys: [
          {
            key: 'module_system_banners',
            value: {
              image: state.banner_image
            },
            serialize: true
          }
        ]
      }

      apiInsertSetting(
        data,
        (result) => {
          commit(MODULE_UPDATE_SETTING_SUCCESS, AppConfig.comInsertNoSuccess);
          commit(MODULE_UPDATE_SET_ERROR, []);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(MODULE_UPDATE_SETTING_FAILED, AppConfig.comInsertNoFail);
          commit(MODULE_UPDATE_SET_ERROR, errors);

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },
    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(MODULE_UPDATE_SET_LOADING, isLoading);
    },
    [ACTION_RESET_NOTIFICATION_INFO]({
      commit
    }, values) {
      commit(MODULE_UPDATE_SETTING_SUCCESS, values)
    },
  },
  modules: {
    category_icon_side_bar: CategoryIconSideBar,
    category_left_side_bar: CategoryLeftSideBar,
    home_banner: HomeBanner,
    thong_bao: ThongBao,
    loi_chua: LoiChua,
    tin_giao_hoi: TinGiaoHoi,
    tin_giao_hoi_viet_nam: TinGiaoHoiVietNam,
    tin_giao_phan: TinGiaoPhan,
    van_kien: VanKien,
    noi_bat: NoiBat,
    special_info_carousel: SpecialInfoCarousel,
  }
}