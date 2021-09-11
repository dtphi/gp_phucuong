import detail from './detail';
import {
  apiGetLists,
} from '@app/api/front/linhmucs';
import {
  INIT_LIST,
  SET_ERROR,
} from '@app/stores/front/types/mutation-types';
import {
  GET_LISTS_LINH_MUC
} from '@app/stores/front/types/action-types';
import {
  MODULE_LINH_MUC_PAGE
} from '@app/stores/front/types/module-types';

export default {
  namespaced: true,
  state: {
    mainMenus: [],
		pageLists: [
		],
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
    [GET_LISTS_LINH_MUC]({
      commit, dispatch
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
              name: MODULE_LINH_MUC_PAGE,
              actionList: GET_LISTS_LINH_MUC
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