import {
  apiGetSettingByCode,
} from '@app/api/front/setting';
import {
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SET_ERROR,
  MODULE_UPDATE_SET_KEYS_DATA,
} from '../../admin/types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_GET_SETTING,
} from '../../admin/types/action-types';
const settingCategory = {
  key: 'module_category_left_side_bar_categories', 
  value: [],
  serialize: true
}

const defaultState = () => {
  return {
    module_category_left_side_bar_categories: settingCategory,
    moduleData: {
      code: 'module_category_left_side_bar',
      keys: [
        settingCategory
      ]
    },
    loading: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    settingCategory(state) {
      return state.module_category_left_side_bar_categories;
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
    }
  },

  mutations: {

    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [MODULE_UPDATE_SET_ERROR](state, payload) {
      state.errors = payload
    },


    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      state.module_category_left_side_bar_categories = payload.module_category_left_side_bar_categories;
      state.moduleData.keys = [];
      state.moduleData.keys.push(payload.module_category_left_side_bar_categories);
    },
  },

  actions: {
    [ACTION_GET_SETTING]({
      dispatch,
      state,
      commit
    }, options) {
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
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(MODULE_UPDATE_SET_LOADING, isLoading);
    },
  }
}
