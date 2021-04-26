import axios from 'axios'
import {
  apiGetLists
} from '@app/api/front/homes';
import {
    apiGetDetail,
    apiGetListsToCategory
  } from '@app/api/front/infos';
import {
  INIT_LIST,
  SET_ERROR,
} from '@app/stores/front/types/mutation-types';
import {
  GET_LISTS,
  GET_DETAIL,
  GET_INFORMATION_LIST_TO_CATEGORY
} from '@app/stores/front/types/action-types';

export default {
    namespaced: true,
    state: {
      mainMenus: [],
      pageLists: [],
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
        MAIN_MENU(state, value) {
            state.mainMenus = value
        },
        INIT_LIST(state, payload) {
          state.pageLists = payload;
        },
        SET_ERROR(state, payload) {
          state.errors = payload;
        }
    },

    actions: {
        [GET_DETAIL]({ commit }, routeParams) {
          if (routeParams.hasOwnProperty('slug')) {
            apiGetDetail(
              routeParams.slug, 
              (result) => {
                  console.log(result)
              },
              (errors)=> {
                  console.log(errors)
              })
          }
        },
        [GET_INFORMATION_LIST_TO_CATEGORY]({ commit }, routeParams) {
          let slug = '';
          if (routeParams.hasOwnProperty('slug')) {
            slug = routeParams.slug;
          }
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
        },
      [GET_LISTS]({
        commit
      }, options) {
        apiGetLists(
        (responses) => {
            commit(INIT_LIST, responses.pageLists);
            commit(SET_ERROR, []);
          },
          (errors) => {
            commit(SET_ERROR, error);
          },
          options
        );
      },
        async menus ({ dispatch }) {
            return await axios.get('/api/main-menus');
        }
    }
}
 