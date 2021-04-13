import axios from 'axios';
import {
  apiInsertInfo
} from 'api@admin/information';
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST
} from '../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_ADD_INFO_TO_CATEGORY_LIST
} from '../types/action-types';

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
    info: {
      image: null,
      date_available: null,
      sort_order: 0,
      status: 1,
      name: '',
      meta_title: '',
      description: '',
      tag: '',
      meta_description: '',
      meta_keyword: '',
      multi_images: [],
      relateds: [],
      categorys: [],
      downloads: []
    },
    listCategorysDisplay: [],
    infoId: 0,
    loading: false,
    insertSuccess: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    isOpen(state) {
      return state.isOpen
    },
    info(state) {
      return state.info
    },
    loading(state) {
      return state.loading
    },
    updateSuccess(state) {
      return state.updateSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    }
  },

  mutations: {

    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_SET_ERROR](state, payload) {
      state.errors = payload
    },

    [INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST](state, payload) {
      state.info.categorys = payload
    },

    [INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST](state, payload) {
      state.listCategorysDisplay = payload
    }
  },

  actions: {

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading);
    },

    [ACTION_INSERT_INFO]({
      dispatch,
      commit
    }, info) {
      apiInsertInfo(
        info,
        (result) => {
          commit(INFOS_MODAL_INSERT_INFO_SUCCESS, true);

          dispatch(ACTION_RELOAD_GET_INFO_LIST, 'page', {
            root: true
          });
          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_INSERT_INFO_FAILED, false)

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_ADD_INFO_TO_CATEGORY_LIST]({commit, state}, category) {
      const categorys = state.info.categorys;
      const listCateShow = state.listCategorysDisplay;

      categorys.push(category.category_id);
      listCateShow.push(category);

      commit(INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST, categorys);
      commit(INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST, listCateShow);
    },
  }
}