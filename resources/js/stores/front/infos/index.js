import detail from './detail';
import {
  apiGetListsToCategory,
  apiGetVideoListsToCategory,
  apiGetPopularList,
  apiGetLastedList
} from '@app/api/front/infos';
import {
  INIT_LIST,
  INIT_INFO_LASTED_LIST,
  INIT_INFO_POPULAR_LIST,
  SET_ERROR,
} from '@app/stores/front/types/mutation-types';
import {
  GET_INFORMATION_LIST_TO_CATEGORY,
  GET_POPULAR_INFORMATION_LIST_TO_CATEGORY,
  GET_LASTED_INFORMATION_LIST_TO_CATEGORY
} from '@app/stores/front/types/action-types';
import {
  MODULE_INFO
} from '../../admin/types/module-types';

export default {
  namespaced: true,
  state: {
    loading: false,
    mainMenus: [],
    pageLists: [],
    infoLastedList: [],
    infoPopularList: [],
    errors: []
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus
    },
    pageLists(state) {
      return state.pageLists;
    }
  },

  mutations: {
    INIT_LIST(state, payload) {
      state.pageLists = payload;
    },
    INIT_INFO_LASTED_LIST(state, payload) {
      state.infoLastedList = payload;
    },
    INIT_INFO_POPULAR_LIST(state, payload) {
      state.infoPopularList = payload;
    },
    SET_ERROR(state, payload) {
      state.errors = payload;
    },
    setLoading(state, payload) {
      state.loading = payload;
    }
  },

  actions: {
    [GET_LASTED_INFORMATION_LIST_TO_CATEGORY]({
      commit
    }, routeParams) {
      commit('setLoading', true);
      if (routeParams.hasOwnProperty('infoType')) {
        apiGetLastedList(
          (result) => {
            commit(INIT_INFO_LASTED_LIST, result.data.results);
            commit(SET_ERROR, []);
            commit('setLoading', false);
          },
          (errors) => {
            console.log(errors);
            commit('setLoading', false);
          },
          routeParams
        )
      } else {
        let params = {
          limit: 15,
          ...routeParams
        };
        apiGetLastedList(
          (result) => {
            commit(INIT_INFO_LASTED_LIST, result.data.results);
            commit(SET_ERROR, []);
            commit('setLoading', false);
          },
          (errors) => {
            console.log(errors);
            commit('setLoading', false);
          },
          params
        )
      }
    },
    [GET_POPULAR_INFORMATION_LIST_TO_CATEGORY]({
      commit
    }, routeParams) {
      commit('setLoading', true);
      if (routeParams.hasOwnProperty('infoType')) {
        apiGetPopularList(
          (result) => {
            commit(INIT_INFO_POPULAR_LIST, result.data.results);
            commit(SET_ERROR, []);
            commit('setLoading', false);
          },
          (errors) => {
            console.log(errors);
            commit('setLoading', false);
          },
          routeParams
        )
      } else {
        apiGetPopularList(
          (result) => {
            commit(INIT_INFO_POPULAR_LIST, result.data.results);
            commit(SET_ERROR, []);
            commit('setLoading', false);
          },
          (errors) => {
            console.log(errors);
            commit('setLoading', false);
          }
        )
      }
    },
    [GET_INFORMATION_LIST_TO_CATEGORY]({
      commit,
      dispatch
    }, routeParams) {
      commit('setLoading', true);
      let slug = '';
      if (routeParams.hasOwnProperty('slug')) {
        slug = routeParams.slug;
      }
      let page = 1;
      if (routeParams.hasOwnProperty('page')) {
        page = routeParams.page;
      }
      let params = {
        page: page,
        slug: slug
      };
      if (routeParams.hasOwnProperty('infoType')) {
        apiGetVideoListsToCategory(
          (result) => {
            commit(INIT_LIST, result.data.results);
            var pagination = {
              current_page: 1,
              total: 0
            };
            if (result.data.hasOwnProperty('pagination')) {
              pagination = result.data.pagination;
            }
            var configs = {
              moduleActive: {
                name: MODULE_INFO,
                actionList: GET_INFORMATION_LIST_TO_CATEGORY
              },
              collectionData: pagination
            };

            dispatch('setConfigApp', configs, {
              root: true
            });

            commit(SET_ERROR, []);
            commit('setLoading', false);
          },
          (errors) => {
            console.log(errors);
            commit('setLoading', false);
          },
          routeParams
        )
      } else {
        apiGetListsToCategory(
          (result) => {
            commit(INIT_LIST, result.data.results);
            var pagination = {
              current_page: 1,
              total: 0
            };
            if (result.data.hasOwnProperty('pagination')) {
              pagination = result.data.pagination;
            }
            var configs = {
              moduleActive: {
                name: MODULE_INFO,
                actionList: GET_INFORMATION_LIST_TO_CATEGORY
              },
              collectionData: pagination
            };

            dispatch('setConfigApp', configs, {
              root: true
            });

            commit(SET_ERROR, []);
            commit('setLoading', false);
          },
          (errors) => {
            console.log(errors);
            commit('setLoading', false);
          },
          params
        )
      }
    },
  },
  modules: {
    detail: detail
  }
}