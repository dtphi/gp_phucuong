import AppConfig from 'api@admin/constants/app-config';
import {
  apiGetSettingByCode,
  apiInsertSetting
} from 'api@admin/setting';
import {
  apiGetCategoryByIds
} from 'api@admin/category';
import {
  SELECT_DROPDOWN_PARENT_CATEGORY,
  SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  MODULE_UPDATE_SET_ERROR,
  MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA,
  MODULE_UPDATE_SET_KEYS_DATA,
  MODULE_UPDATE_SET_INIT_DROP_DOWN_CATEGORY_LIST,
} from '../../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SELECT_DROPDOWN_PARENT_CATEGORY,
  ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
  ACTION_INSERT_SETTING,
  ACTION_GET_SETTING,
  ACTION_GET_CATEGORY_LIST_BY_IDS,
  ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA,
} from '../../types/action-types';
const settingCategory = {
  key: 'module_tin_giao_hoi_categories', 
  value: [],
  serialize: true
}

const defaultState = () => {
  return {
    module_tin_giao_hoi_categories: settingCategory,
    moduleData: {
      code: 'module_tin_giao_hoi',
      keys: [
        settingCategory
      ]
    },
    infoCategory: {
      category_name: '',
      category_id: null
    },
    dropdownCategory: [],
    nameQuery: '',
    newsGroupId: 0,
    loading: false,
    updateSuccess: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    dropdownCategory(state) {
      return state.dropdownCategory;
    },
    settingCategory(state) {
      return state.module_tin_giao_hoi_categories;
    },
    moduleData(state) {
      return state.moduleData
    },
    infoCategory(state) {
      return state.infoCategory
    },
    getNameQuery(state) {
      var str = state.nameQuery;

      if (typeof str === 'undefined' || str === null) {
        return '';
      }
      return str;
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

    [SELECT_DROPDOWN_PARENT_CATEGORY](state, payload) {
      if (parseInt(payload.category_id) !== parseInt(state.newsGroupId)) {
        state.nameQuery = payload.name;
        state.newsGroup.parent_id = payload.category_id;
      }
    },

    [SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY](state, payload) {
      state.nameQuery = payload.name;
      state.infoCategory = payload;
    },

    [MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA](state, payload) {
      state.module_tin_giao_hoi_categories.value = payload;
    },

    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      state.module_tin_giao_hoi_categories = payload.module_tin_giao_hoi_categories;
      state.moduleData.keys = [];
      state.moduleData.keys.push(payload.module_tin_giao_hoi_categories);
    },

    [MODULE_UPDATE_SET_INIT_DROP_DOWN_CATEGORY_LIST](state, payload) {
      state.dropdownCategory = payload;
    }
  },

  actions: {
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

            dispatch(ACTION_GET_CATEGORY_LIST_BY_IDS, res.data.results.module_tin_giao_hoi_categories.value);
          } else {
            dispatch(ACTION_SET_LOADING, false);
          }
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false);
        }
      );
    },

    [ACTION_GET_CATEGORY_LIST_BY_IDS]({commit, dispatch}, cateIds) {
      const params = {
        cateIds: cateIds
      }
      apiGetCategoryByIds(
        (res) => {
          commit(MODULE_UPDATE_SET_INIT_DROP_DOWN_CATEGORY_LIST, res);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false);
        },
        params
      );
    },

    [ACTION_INSERT_SETTING]({commit, dispatch}, settingData) {
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

    [ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA]({commit}, payload) {
      commit(MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA, payload)
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