import detail from './detail';
import {
  apiGetLists
} from '@app/api/front/giaoxus';

import {
  INIT_LIST,
  SET_ERROR,
} from '@app/stores/front/types/mutation-types';
import {
  MODULE_GIAO_XU_PAGE
} from '@app/stores/front/types/module-types';
import {
  GET_LISTS
} from '@app/stores/front/types/action-types';

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    loading: false,
    errors: []
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus;
    },
    pageLists(state) {
      return state.pageLists;
    },
    loading(state) {
      return state.loading;
    }
  }, 

  mutations: {
    MAIN_MENU(state, value) {
      state.mainMenus = value
    },
    INIT_LIST(state, payload) {
      state.pageLists = payload;
    },
    SET_ERROR(state, payload) {
      state.errors = payload;
    },
    setLoading(state, payload) {
      state.loading = payload;
    }
  },

  actions: {
    [GET_LISTS]({
      commit,
      dispatch
    }, options) {
      commit('setLoading', true);
      apiGetLists(
        (responses) => {
          commit(INIT_LIST, responses.data.results);
          commit(SET_ERROR, []);
          var pagination = {
            current_page: 1,
            total: 0
          };
          if (responses.data.hasOwnProperty('pagination')) {
						pagination = responses.data.pagination;
          }
          var configs = {
            moduleActive: {
              name: MODULE_GIAO_XU_PAGE,
              actionList: GET_LISTS
            },
            collectionData: pagination
					};
					dispatch('setConfigApp', configs, {
						root: true,
					});
          commit('setLoading', false);
        },
        (errors) => {
          commit(SET_ERROR, errors);
          commit('setLoading', false);
        },
        options
      );
    },
  },
  modules: {
    detail: detail
  }
}