import {
    apiGetSettingByCode,
  } from '@app/api/front/setting';
  
  import {
    INIT_LIST,
  } from '@app/stores/front/types/mutation-types';
  import {
    MODULE_UPDATE_SET_LOADING,
    MODULE_UPDATE_SET_ERROR,
    MODULE_UPDATE_SET_KEYS_DATA,
  } from '../../admin/types/mutation-types';
  import {
    ACTION_SET_LOADING,
    ACTION_GET_SETTING
  } from '../../admin/types/action-types';
  
  const settingSachNoi = {};
  const settingYoutube ={};
  const settingHanhCacThanh ={};
  const settingBanner = {};
  const settingBannerFormat = {};
  
  const defaultState = () => {
    return {
      module_noi_bat_sach_nois: {},
      module_noi_bat_youtubes: {},
      module_noi_bat_hanh_cac_thanhs: {},
      module_noi_bat_banners: {},
      module_noi_bat_banner_formats: {},
      moduleData: {
        code: 'module_noi_bat',
        keys: [
          settingSachNoi,
          settingYoutube,
          settingHanhCacThanh,
          settingBanner,
          settingBannerFormat
        ]
      },
      pageLists: [],
      loading: false,
      errors: []
    }
  }
  
  export default {
    namespaced: true,
    state: defaultState(),
    getters: {
      settingSachNoi(state) {
        return state.module_noi_bat_sach_nois;
      },
      settingYoutube(state) {
        return state.module_noi_bat_youtubes;
      },
      settingHanhCacThanh(state) {
        return state.module_noi_bat_hanh_cac_thanhs;
      },
      settingBanner(state) {
        return state.module_noi_bat_banners
      },
      settingBannerFormat(state) {
        return state.module_noi_bat_banner_formats
      },
      moduleData(state) {
        return state.moduleData
      },
  
      loading(state) {
        return state.loading
      },
      errors(state) {
        return state.errors
      },
      isError(state) {
        return state.errors.length
      },
      pageLists(state) {
        return state.pageLists;
      }
    },
  
    mutations: {
      [INIT_LIST](state, payload) {
        state.pageLists = payload;
      },
  
      [MODULE_UPDATE_SET_LOADING](state, payload) {
        state.loading = payload
      },
  
      [MODULE_UPDATE_SET_ERROR](state, payload) {
        state.errors = payload
      },
  
  
      [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
        if (payload.hasOwnProperty('module_noi_bat_banner_formats')) {
          state.module_noi_bat_banner_formats = payload.module_noi_bat_banner_formats;
        }
        if (payload.hasOwnProperty('module_noi_bat_banners')) {
          state.module_noi_bat_banners = payload.module_noi_bat_banners;
        }
        if (payload.hasOwnProperty('module_noi_bat_sach_nois')) {
          state.module_noi_bat_sach_nois  = payload.module_noi_bat_sach_nois;
        }
        if (payload.hasOwnProperty('module_noi_bat_youtubes')) {
          state.module_noi_bat_youtubes = payload.module_noi_bat_youtubes;
        }
        if (payload.hasOwnProperty('module_noi_bat_hanh_cac_thanhs')) {
          state.module_noi_bat_hanh_cac_thanhs = payload.module_noi_bat_hanh_cac_thanhs;
        }
        state.moduleData.keys = [];
        state.moduleData.keys.push(payload.module_noi_bat_sach_nois);
        state.moduleData.keys.push(payload.module_noi_bat_youtubes);
        state.moduleData.keys.push(payload.module_noi_bat_hanh_cac_thanhs);
        state.moduleData.keys.push(state.module_noi_bat_banners);
        state.moduleData.keys.push(state.module_noi_bat_banner_formats);
      },
    },
  
    actions: {
      [ACTION_GET_SETTING]({
        dispatch,
        state,
        commit
      }, options) {
        if (options) {
          commit(MODULE_UPDATE_SET_KEYS_DATA, options);
        } else {
          dispatch(ACTION_SET_LOADING, true);
          const params = {
            code: state.moduleData.code
          }
          apiGetSettingByCode(
            (res) => {
              if (Object.keys(res.data.moduleData).length) {
                commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.moduleData);
              } else {
                dispatch(ACTION_SET_LOADING, false);
              }
            },
            (errors) => {
              dispatch(ACTION_SET_LOADING, false);
            },
            params
          );
        }
      },
  
      [ACTION_SET_LOADING]({
        commit
      }, isLoading) {
        commit(MODULE_UPDATE_SET_LOADING, isLoading);
      },
    }
  }