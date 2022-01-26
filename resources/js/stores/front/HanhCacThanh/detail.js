import { apiGetDetail, apiGetListsToCategory, } from '@app/api/front/HanhCacThanh'
import { INIT_LIST, INIT_RELATED_LIST, SET_ERROR,
} from '@app/stores/front/types/mutation-types'
import { GET_DETAIL, GET_LIST_NGAY_LE,
} from '@app/stores/front/types/action-types'
import { fnCheckProp, } from '@app/common/util'

export default {
  namespaced: true,
  state: {
    mainMenus: [],
    pageLists: {
      name: '',
      description: '',
    },
    infoRelateds: [],
    errors: [],
  },
  getters: {
    mainMenus(state) {
      return state.mainMenus
    },
    pageLists(state) {
      return state.pageLists
    },
    infoRelateds(state) {
      return state.infoRelateds
    },
  },
  mutations: {
    [INIT_LIST](state, payload) {
      state.pageLists = payload
    },
    [INIT_RELATED_LIST](state, payload) {
      state.infoRelateds = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },
  actions: {
    [GET_DETAIL]({ commit, dispatch, }, routeParams) {
      if (fnCheckProp(routeParams, 'slug')) {
        apiGetDetail(routeParams.slug,
          (result) => {
            commit(INIT_LIST, result.data.results)
            dispatch(GET_LISTS_NGAY_LE, {
              slug: `category-related-${result.data.results.related_category}`,
            })
          },
          (errors) => {
            commit(SET_ERROR, errors)
          }, routeParams)
      }
    },
    [GET_LIST_NGAY_LE]({ commit, }, routeParams) {
      let page = 1
      let params = { limit: 7, page: page, ...routeParams, }
      apiGetListsToCategory((result) => {
        commit(INIT_RELATED_LIST, result.data.results)
      }, (errors) => {
        commit(SET_ERROR, errors)
      }, params)
    },
  },
}