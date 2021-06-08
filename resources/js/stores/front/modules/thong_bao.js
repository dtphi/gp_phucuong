import {
    apiGetSettingByCode,
  } from '@app/api/front/setting';
  import {
    apiGetListsToCategory
  } from '@app/api/front/infos';
  import {
    INIT_LIST,
  } from '@app/stores/front/types/mutation-types';
  import {
    GET_INFORMATION_LIST_TO_CATEGORY,
  } from '@app/stores/front/types/action-types';
  import {
    MODULE_UPDATE_SET_LOADING,
    MODULE_UPDATE_SET_ERROR,
    MODULE_UPDATE_SET_KEYS_DATA,
  } from '../../admin/types/mutation-types';
  import {
    ACTION_SET_LOADING,
    ACTION_GET_SETTING
  } from '../../admin/types/action-types';
  const settingCategory = [];
  
  const defaultState = () => {
    return {
      module_thong_bao_categories: settingCategory,
      moduleData: {
        code: 'module_thong_bao',
        keys: [
          settingCategory
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
      settingCategory(state) {
        return state.module_thong_bao_categories;
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
        state.module_thong_bao_categories = payload.module_thong_bao_categories;
        state.moduleData.keys = [];
        state.moduleData.keys.push(payload.module_thong_bao_categories);
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
  
          dispatch(GET_INFORMATION_LIST_TO_CATEGORY, options[0]);
        } else {
          dispatch(ACTION_SET_LOADING, true);
          const params = {
            code: state.moduleData.code
          }
          apiGetSettingByCode(
            (res) => {
              if (Object.keys(res.data.moduleData).length) {
                commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.moduleData);
  
                dispatch(GET_INFORMATION_LIST_TO_CATEGORY, res.data.moduleData.module_thong_bao_categories[0]);
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

      [GET_INFORMATION_LIST_TO_CATEGORY]({
        commit,
        dispatch
      }, routeParams) {
        let slug = '';
        if (routeParams.hasOwnProperty('link')) {
          slug = routeParams.link;
        }
        let page = 1;
        let params = {
          page: page,
          slug: slug,
          limit: 5
        };
        apiGetListsToCategory(
          (result) => {
            commit(INIT_LIST, result.data.results);
          },
          (errors) => {
            console.log(errors);
          },
          params
        )
      },
  
      [ACTION_SET_LOADING]({
        commit
      }, isLoading) {
        commit(MODULE_UPDATE_SET_LOADING, isLoading);
      },
    }
  }