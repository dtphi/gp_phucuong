import {
  apiGetDetail
} from '@app/api/front/giaoxus';
import {
  INIT_LIST,
} from '@app/stores/front/types/mutation-types';
import {
  GET_DETAIL
} from '@app/stores/front/types/action-types';

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: {
      name: '',
      description: ''
    },
    infoRelateds: [],
    errors: []
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus
    },
    pageLists(state) {
      return state.pageLists;
    },
    infoRelateds(state) {
      return state.infoRelateds;
    }
  }, 

  mutations: {
    INIT_LIST(state, payload) {
      state.pageLists = payload;
    },
    SET_ERROR(state, payload) {
      state.errors = payload;
    }
  },

  actions: {
    [GET_DETAIL]({
      commit,
      dispatch
    }, routeParams) {
      if (routeParams.hasOwnProperty('giaoXuId')) {
        apiGetDetail(
          routeParams.giaoXuId,
          (result) => {
            console.log(result)
            commit(INIT_LIST, result);
          },
          (errors) => {
            console.log(errors)
          },
          routeParams
        )
      }
    }
  }
}