import detail from './detail';
import {
  apiGetLists,
  apiGetListsChucVu,
  apiGetListsLinhMuc 
} from '@app/api/front/linhmucs';
import {
  INIT_LIST,
  SET_ERROR,
} from '@app/stores/front/types/mutation-types';
import {
  GET_LISTS_LINH_MUC,
  GET_LISTS_LINH_MUC_BY_ID,
  GET_LISTS_CHUC_VU
} from '@app/stores/front/types/action-types';
import {
  MODULE_LINH_MUC_PAGE
} from '@app/stores/front/types/module-types';

export default {
  namespaced: true,
  state: {
    mainMenus: [],
		pageLists: [],
    linhMucLists: [],
    chucVuLists: [],
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
    },
    chucVuLists(state) {
      return state.chucVuLists;
    },
    linhMucLists(state) {
      return state.linhMucLists;
    },

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
    },
    INIT_CHUC_VU_LIST(state, payload) {
      state.chucVuLists = payload;
    },
    INIT_LINH_MUC_BY_ID_LIST(state, payload) {
      state.linhMucLists = payload;
    },
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

    async [GET_LISTS_CHUC_VU]({
      commit
    }) {
      commit('setLoading', true);
      await apiGetListsChucVu(
        (infos) => {
          commit('INIT_CHUC_VU_LIST', infos.data.results);
          commit('setLoading', false);
        },
        (errors) => {
          commit('setLoading', false);
        },
      );
    },

    async [GET_LISTS_LINH_MUC_BY_ID]({ 
      commit
    }, params) {
      commit('setLoading', true);
      await apiGetListsLinhMuc(
        (infos) => {
          commit('INIT_LINH_MUC_BY_ID_LIST', infos.data.results);
          commit('setLoading', false);
        },
        (errors) => {
          commit('setLoading', false);
        },
        params
      );
    },
  },
  modules: {
    detail: detail
  }
}