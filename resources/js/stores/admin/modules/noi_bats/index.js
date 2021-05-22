import AppConfig from 'api@admin/constants/app-config';
import {
  apiGetSettingByCode,
  apiInsertSetting
} from 'api@admin/setting';
import {
  SELECT_DROPDOWN_PARENT_CATEGORY,
  SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  MODULE_UPDATE_SET_ERROR,
  MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA,
  MODULE_UPDATE_SET_KEYS_DATA,
} from '../../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SELECT_DROPDOWN_PARENT_CATEGORY,
  ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
  ACTION_INSERT_SETTING,
  ACTION_GET_SETTING,
} from '../../types/action-types';
const settingSachNoi = {
  key: 'module_noi_bat_sach_nois',
  value: [],
  serialize: true
}
const settingYoutube = {
  key: 'module_noi_bat_youtubes',
  value: [],
  serialize: true
}
const settingHanhCacThanh = {
  key: 'module_noi_bat_hanh_cac_thanhs',
  value: [],
  serialize: true
}

const defaultState = () => {
  return {
    module_noi_bat_sach_nois: settingSachNoi,
    module_noi_bat_youtubes: settingYoutube,
    module_noi_bat_hanh_cac_thanhs: settingHanhCacThanh,
    moduleData: {
      code: 'module_noi_bat',
      keys: [
        settingSachNoi,
        settingYoutube,
        settingHanhCacThanh
      ]
    },
    loading: false,
    updateSuccess: false,
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

    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
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

    [MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA](state, payload) {
      state.module_noi_bat_hanh_cac_thanhs.value = payload;
    },

    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      state.module_noi_bat_sach_nois = payload.module_noi_bat_sach_nois;
      state.module_noi_bat_youtubes = payload.module_noi_bat_youtubes;
      state.module_noi_bat_hanh_cac_thanhs = payload.module_noi_bat_hanh_cac_thanhs;
      state.moduleData.keys = [];
      state.moduleData.keys.push(payload.module_noi_bat_sach_nois);
      state.moduleData.keys.push(payload.module_noi_bat_youtubes);
      state.moduleData.keys.push(payload.module_noi_bat_hanh_cac_thanhs);
    }
  },

  actions: {
    module_noi_bat_sach_nois({state}, value) {
      console.log(value),
      state.module_noi_bat_sach_nois.value.push({
        title: '',
        url_title: '',
        author: '',
        sort_order: 0
      })
    },
    module_noi_bat_youtubes({state}, value) {
      console.log(value)
      state.module_noi_bat_youtubes.value.push({
        title: '',
        url_full: '',
        author: '',
        sort_order: 0
      })
    },
    module_noi_bat_hanh_cac_thanhs({state}, value) {
      console.log(value)
      state.module_noi_bat_hanh_cac_thanhs.value.push({
        title: '',
        url_full: '',
        author: '',
        sort_order: 0
      })
    },
    [ACTION_GET_SETTING]({
      dispatch,
      state,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetSettingByCode(
        state.moduleData.code,
        (res) => {
          if (Object.keys(res.data.results).length) {
            commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.results);

            dispatch(ACTION_SET_LOADING, false);
            //dispatch(ACTION_GET_CATEGORY_LIST_BY_IDS, res.data.results.module_noi_bat_hanh_cac_thanhs.value);
          } else {
            dispatch(ACTION_SET_LOADING, false);
          }
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false);
        }
      );
    },

    [ACTION_INSERT_SETTING]({
      commit,
      dispatch
    }, settingData) {
      console.log(settingData)
      dispatch(ACTION_SET_LOADING, true);
      apiInsertSetting(
        settingData,
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

    [ACTION_SELECT_DROPDOWN_PARENT_CATEGORY]({
      commit
    }, category) {
      commit(SELECT_DROPDOWN_PARENT_CATEGORY, category);
    },

    [ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY]({
      commit
    }, category) {
      commit(SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY, category);
    }
  }
}