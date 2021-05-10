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

export default {
    namespaced: true,
    state: {
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
        }
    },

    actions: {
      [GET_LASTED_INFORMATION_LIST_TO_CATEGORY]({ commit }, routeParams) {
          
        if (routeParams.hasOwnProperty('infoType')) {
          apiGetLastedList(
            (result) => {
              commit(INIT_INFO_LASTED_LIST, result.data.results);
              commit(SET_ERROR, []);
            },
            (errors)=> {
                console.log(errors)
            },
            routeParams
          )
        } else {
          apiGetLastedList(
            (result) => {
              commit(INIT_INFO_LASTED_LIST, result.data.results);
              commit(SET_ERROR, []);
            },
            (errors)=> {
                console.log(errors)
            }
          )
        }
      },
        [GET_POPULAR_INFORMATION_LIST_TO_CATEGORY]({ commit }, routeParams) {
          
          if (routeParams.hasOwnProperty('infoType')) {
            apiGetPopularList(
              (result) => {
                commit(INIT_INFO_POPULAR_LIST, result.data.results);
                commit(SET_ERROR, []);
              },
              (errors)=> {
                  console.log(errors)
              },
              routeParams
            )
          } else {
            apiGetPopularList(
              (result) => {
                commit(INIT_INFO_POPULAR_LIST, result.data.results);
                commit(SET_ERROR, []);
              },
              (errors)=> {
                  console.log(errors)
              }
            )
          }
        },
        [GET_INFORMATION_LIST_TO_CATEGORY]({ commit }, routeParams) {
          let slug = '';
          if (routeParams.hasOwnProperty('slug')) {
            slug = routeParams.slug;
          }
          if (routeParams.hasOwnProperty('infoType')) {
            apiGetVideoListsToCategory(
              (result) => {
                commit(INIT_LIST, result.data.results);
                commit(SET_ERROR, []);
              },
              (errors)=> {
                  console.log(errors)
              },
              routeParams
            )
          } else {
            apiGetListsToCategory(
              (result) => {
                commit(INIT_LIST, result.data.results);
                commit(SET_ERROR, []);
              },
              (errors)=> {
                  console.log(errors)
              },
              slug
            )
          }
        },
    },
    modules: {
      detail: detail
    }
}
 