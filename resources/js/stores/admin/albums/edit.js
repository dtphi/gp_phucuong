import AppConfig from 'api@admin/constants/app-config';
import {
  apiGetAlbumsById,
  apiUpdateAlbums
} from 'api@admin/albums';
import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_SUCCESS,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE
} from '../types/mutation-types';
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SET_IMAGE,
} from '../types/action-types';
import {
  config
} from '@app/api/admin/config';

const defaultState = () => {
  return {
    styleCss: '',
    isExistInfo: config.existStatus.checking,
    info: {
      image: {
        basename: "",
        dirname: "",
        extension: "",
        filename: "",
        path: "",
        size: 0,
        thumb: "", //url thumb
        timestamp: null,
        type: null
      },
      sort_id: 0,
      status: 1,
      albums_name: '',    
      group_images: [],
      group_albums_id: null,
      id: null,
    },
    isImgChange: false,
    infoId: 0,
    loading: false,
    updateSuccess: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
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
    },
    isNotExistValidate(state) {
      if (state.isExistInfo !== config.existStatus.checking ||
        state.isExistInfo !== config.existStatus.exist) {
        return false;
      }

      return true;
    }
  },

  mutations: {

    [INFOS_MODAL_SET_INFO_ID](state, payload) {
      if (payload) {
        state.infoId = payload;
        state.isExistInfo = config.existStatus.exist;
      }
    },

    [INFOS_MODAL_SET_INFO_ID_FAILED](state, payload) {
      state.errors = payload
    },

    [INFOS_MODAL_SET_INFO](state, payload) {
      state.info = payload
    },

    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_UPDATE_INFO_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_UPDATE_INFO_FAILED](state, payload) {
      state.updateSuccess = payload
    },

    [INFOS_MODAL_SET_ERROR](state, payload) {
      state.errors = payload
    },

    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload;
      state.isImgChange = true;
    }
  },

  actions: {
    update_albums_images({state}, albums_images) {
      state.info.group_images = albums_images;
    },

    [ACTION_SHOW_MODAL_EDIT]({
      dispatch,
    }, infoId) {
      dispatch(ACTION_GET_INFO_BY_ID, infoId);
    },

    [ACTION_GET_INFO_BY_ID]({
      dispatch,
      commit
    }, infoId) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetAlbumsById(
        infoId,
        (result) => {
          commit(INFOS_MODAL_SET_INFO_ID, infoId);
          commit(INFOS_MODAL_SET_INFO, result.data.data);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_SET_INFO_ID_FAILED, Object.values(errors))

          dispatch(ACTION_SET_LOADING, false);
        }
      );
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading);
    },

    [ACTION_UPDATE_INFO]({
      dispatch,
      commit
    }, info) {  
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '');  
      apiUpdateAlbums(info,
        (result) => {
          commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, AppConfig.comUpdateNoSuccess);
          dispatch(ACTION_SET_LOADING, false);
          dispatch(ACTION_GET_INFO_BY_ID, info.id);
        },
        (errors) => {
          commit(INFOS_MODAL_UPDATE_INFO_FAILED, AppConfig.comUpdateNoFail)
          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_RESET_NOTIFICATION_INFO]({
      commit
    }, values) {
      commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values);
    },

    [ACTION_SET_IMAGE]({
      commit
    }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile);
    },
  }
}