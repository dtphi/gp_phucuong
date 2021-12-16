import detail from './detail';
import {
  apiGetLists,
  apiGetListsGiaoXu,
  apiSearchItem,
} from '@app/api/front/giaoxus';
import {
  apiGetListsGiaoPhan
} from '@app/api/front/giaophans';
import {
  apiGetListsGiaoHat
} from '@app/api/front/giaohats';

import {
  SET_ERROR,
  INIT_LIST
} from '@app/stores/front/types/mutation-types';
import {
  MODULE_GIAO_XU_PAGE
} from '@app/stores/front/types/module-types';
import {
  GET_LISTS,
  GET_LISTS_GIAO_PHAN,
  GET_LISTS_GIAO_HAT,
  GET_LISTS_GIAO_XU,
  ACTION_SEARCH_ITEMS,
  ACTION_GET_PAGE_SEARCH,
  ACTION_REFESH_LIST_SEARCH,
  ACTION_REFESH_LIST_FILTER
} from '@app/stores/front/types/action-types';

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
    giaoPhanLists:[],
    giaoHatLists: [],
    giaoXuLists:[],
    loading: false,
    paginationFilter: [],
    paginationSearch: [],
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
    giaoPhanLists(state) {
      return state.giaoPhanLists;
    },
    giaoHatLists(state) {
      return state.giaoHatLists;
    },
    giaoXuLists(state) {
      return state.giaoXuLists;
    },
    paginationFilter(state) {
      return state.paginationFilter;
    },
    paginationSearch(state) {
      return state.paginationSearch;
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
    },
    INIT_GIAO_PHAN_LIST(state, payload) {
      state.giaoPhanLists = payload;
    },
    INIT_GIAO_HAT_LIST(state, payload) {
      state.giaoHatLists = payload;
    },
    INIT_GIAO_XU_LIST(state, payload) {
      state.giaoXuLists = payload;
    },
    INIT_PAGINATION_FILTER(state, payload) {
      state.paginationFilter = payload;
    },
    INIT_PAGINATION_SEARCH(state, payload) {
      state.paginationSearch = payload;
    },
    INIT_REFRESH_LIST(state, payload) {
      state.giaoXuLists = payload;
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

    async [GET_LISTS_GIAO_PHAN]({
      commit
    }) {
      commit('setLoading', true);
      await apiGetListsGiaoPhan(
        (infos) => {
          commit('INIT_GIAO_PHAN_LIST', infos.data.results);
          commit('setLoading', false);
        },
        (errors) => {
          commit('setLoading', false);
        },
      );
    },

    async [GET_LISTS_GIAO_HAT]({ 
      commit
    }, params) {
      commit('setLoading', true);
      await apiGetListsGiaoHat(
        (infos) => {
          commit('INIT_GIAO_HAT_LIST', infos.data.results);
          commit('setLoading', false);
        },
        (errors) => {
          commit('setLoading', false);
        },
        params
      );
    },

    async [GET_LISTS_GIAO_XU]({ 
      commit, dispatch
    }, options) {
      commit('setLoading', true);
      await apiGetListsGiaoXu(
        (response) => {
          dispatch(ACTION_REFESH_LIST_SEARCH);
          commit('INIT_GIAO_XU_LIST', response.data.results);
          commit('INIT_PAGINATION_FILTER', response.data.pagination);
          commit('setLoading', false);
        },
        (errors) => {
          commit('setLoading', false);
        },
        options
      );
    },

    [ACTION_SEARCH_ITEMS]({
      commit, dispatch
     }, options) {
       apiSearchItem(
         (response) => {
          dispatch(ACTION_REFESH_LIST_FILTER);
          commit('INIT_GIAO_XU_LIST', response.data.results);
          if (response.data.hasOwnProperty('pagination')) {
            commit('INIT_PAGINATION_SEARCH', response.data.pagination);
          }
        },
        (errors) => {
          commit('INIT_GIAO_XU_LIST', errors);
        },
        options,
      );
    },

    [ACTION_GET_PAGE_SEARCH]({
      commit}, options){
        apiSearchItem(
            (response) => {
              commit('INIT_GIAO_XU_LIST', response.data.results); 
              if (response.data.hasOwnProperty('pagination')) {
                commit('INIT_PAGINATION_SEARCH', response.data.pagination);
              } 
            },
            (errors) => {
                console.log(errors);
            },
            options)   
    },

    [ACTION_REFESH_LIST_SEARCH]({commit}) {
        commit('INIT_REFRESH_LIST', []);
        commit('INIT_PAGINATION_SEARCH', [])
    },

    [ACTION_REFESH_LIST_FILTER]({commit}) {
      commit('INIT_REFRESH_LIST', []);
      commit('INIT_PAGINATION_FILTER', [])
    }
  },

  modules: {
    detail: detail
  }
}