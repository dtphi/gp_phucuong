import { apiGetDetail, apiGetListsToCategory, apiGetInfoTag } from '@app/api/front/infos'
import { INIT_LIST, INIT_RELATED_LIST, SET_ERROR,
} from '@app/stores/front/types/mutation-types'
import { GET_DETAIL, GET_RELATED_INFORMATION_LIST_TO_CATEGORY,
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
    infoTag: [],
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
    infoTag(state) {
      return state.infoTag
    }
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
    INFO_TAG(state, payload) {
      state.infoTag = payload
    }
  },
  actions: {
    [GET_DETAIL]({ commit, dispatch, }, routeParams) {
      if (fnCheckProp(routeParams, 'slug')) {
        apiGetDetail(routeParams.slug,
          (result) => {
            console.log(result.data.results, 'tets')
            commit(INIT_LIST, result.data.results)
            dispatch(GET_RELATED_INFORMATION_LIST_TO_CATEGORY, {
              slug: `category-related-${result.data.results.related_category}`,
            })
          },
          (errors) => {
            commit(SET_ERROR, errors)
          }, routeParams)
      }
    },
    [GET_RELATED_INFORMATION_LIST_TO_CATEGORY]({ commit, }, routeParams) {
      let page = 1
      let params = { limit: 7, page: page, ...routeParams, }
      apiGetListsToCategory((result) => {
        commit(INIT_RELATED_LIST, result.data.results)
      }, (errors) => {
        commit(SET_ERROR, errors)
      }, params)
    },

    GET_INFO_TAG({ commit }, routeParams) {
      if (fnCheckProp(routeParams, 'slug')) {
        apiGetInfoTag(routeParams.slug,
          (result) => {
            commit('INFO_TAG', result.data.results)
            // dispatch(GET_RELATED_INFORMATION_LIST_TO_CATEGORY, {
            //   slug: `category-related-${result.data.results.related_category}`,
            // })
          },
          (errors) => {
            commit(SET_ERROR, errors)
          }, routeParams)
      }
    }
  },
}
