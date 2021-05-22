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
  const      settingYoutube ={};
  const     settingHanhCacThanh ={};
  
  const defaultState = () => {
    return {
      module_noi_bat_sach_nois: {},
      module_noi_bat_youtubes: {},
      module_noi_bat_hanh_cac_thanhs: {},
      moduleData: {
        code: 'module_noi_bat',
        keys: [
          settingSachNoi,
          settingYoutube,
          settingHanhCacThanh
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
        state.module_noi_bat_sach_nois = payload.module_noi_bat_sach_nois;
        state.module_noi_bat_youtubes = payload.module_noi_bat_youtubes;
        state.module_noi_bat_hanh_cac_thanhs = payload.module_noi_bat_hanh_cac_thanhs;
        state.moduleData.keys = [];
        state.moduleData.keys.push(payload.module_noi_bat_sach_nois);
        state.moduleData.keys.push(payload.module_noi_bat_youtubes);
        state.moduleData.keys.push(payload.module_noi_bat_hanh_cac_thanhs);
      },
    },
  
    actions: {
      [ACTION_GET_SETTING]({
        dispatch,
        state,
        commit
      }, options) {
        dispatch(ACTION_SET_LOADING, true);console.log('noi bat')
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
      },
  
      [ACTION_SET_LOADING]({
        commit
      }, isLoading) {
        commit(MODULE_UPDATE_SET_LOADING, isLoading);
      },
    }
  }