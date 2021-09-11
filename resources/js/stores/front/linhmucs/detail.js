import {
  apiGetDetail
} from '@app/api/front/linhmucs';
import {
  INIT_LIST,
} from '@app/stores/front/types/mutation-types';
import {
  GET_DETAIL_LINH_MUC,
} from '@app/stores/front/types/action-types';

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: [],
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
    [GET_DETAIL_LINH_MUC]({
      commit,
    }, routeParams) {
        apiGetDetail(
          routeParams.linhMucId,
          (responses) => {
            commit(INIT_LIST, responses.data);          
          },
          (errors) => {
            console.log(errors, 'errors')
          },
          routeParams
        )
      }
    }
}