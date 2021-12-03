import AppConfig from 'api@admin/constants/app-config';
import { v4 as uuidv4 } from 'uuid';
import {
  apiInsertInfoAlbums,
} from 'api@admin/albums';
import {
  apiGetAllGroupAlbums,
} from 'api@admin/groupalbums';
import {
  MODULE_MODULE_ALBUMS,
} from '../types/module-types';
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  INFOS_MODAL_SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
  INFOS_GET_INFO_LIST_FAILED,
  MODULE_UPDATE_SET_KEYS_DATA
} from '../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_GET_SETTING,
  ACTION_RELOAD_GET_INFO_LIST,
} from '../types/action-types';

const infoAlbumsImage = {
  value: []
}

const defaultState = () => {
  return {
    isOpen: false,
    action: null,
    classShow: 'modal fade',
    styleCss: '',
		info: {
      albums_name: '',
      group_albums_id: null,
      status: 1,
      sort_id: 1,
      albums_images: [],
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
    },
    list_group_albums: [],
    isImgChange: true,
    loading: false,
    insertSuccess: false,
    errors: [],
    infoAlbumsImage: infoAlbumsImage,
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
    insertSuccess(state) {
      return state.insertSuccess
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    },
    isGroupAlbums(state) {
      return state.list_group_albums;
    },
    infoAlbumsImage(state) {
      return state.infoAlbumsImage;
    }
  },

  mutations: {
    [INFOS_MODAL_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
      state.insertSuccess = payload
    },

    [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
      state.insertSuccess = payload
    },

    [INFOS_MODAL_SET_ERROR](state, payload) {
      state.errors = payload
    },

    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.info.image = payload;
      state.isImgChange = true;
    },
    INFO_GROUP_ALBUMS(state, payload) {
      state.list_group_albums = payload;
    },
    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      state.infoAlbumsImage.value = payload;
    }
  },

  actions: {
    pushInfoAlbumsImage({state}, value) {
      const data = {
        id: uuidv4(),
        status: 1,
        open: 0,
        image: value.filePath,
        width: 700,
        height: 450,
      };
      state.infoAlbumsImage.value.push(data);
    },

    removeInfoAlbumsImage({state}, banner) {
      console.log(banner, 'banner');
      let banners = state.infoAlbumsImage.value;
      if(state.infoAlbumsImage.value.length > 0) {
        state.infoAlbumsImage.value = _.remove(banners, function(item) {
          return !(item.id == banner.id);
        })
      }
    },

    update_info_albums_image({state}, albumsImage) {
      state.info.albums_images = albumsImage;
    },

    [ACTION_GET_SETTING]({
      commit
    }, albumsImage) {
      if (albumsImage.length) {
        commit(MODULE_UPDATE_SET_KEYS_DATA, albumsImage);
      }
    },

    // GET LIST GROUP ALBUMS
    ACTION_GET_LIST_GROUP_ALBUMS({ commit }, params) {
      apiGetAllGroupAlbums(
        (infos) => {
          commit('INFO_GROUP_ALBUMS', infos.data.results);
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, errors)
        },
        params
      )
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_MODAL_SET_LOADING, isLoading);
    },

    // ACTION INSERT ALBUMS
    [ACTION_INSERT_INFO]({
      dispatch,
      commit
    }, info) {
      apiInsertInfoAlbums(
        info,
        (result) => {
          commit(INFOS_MODAL_INSERT_INFO_SUCCESS, AppConfig.comInsertNoSuccess);
          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_MODAL_INSERT_INFO_FAILED, AppConfig.comInsertNoFail);
          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_INSERT_INFO_BACK]({
      dispatch,
      commit
    }, info) {
      apiInsertInfoAlbums(
        info,
        (result) => {
          commit(INFOS_MODAL_INSERT_INFO_SUCCESS, AppConfig.comInsertNoSuccess);
          dispatch(MODULE_MODULE_ALBUMS + '_' + ACTION_RELOAD_GET_INFO_LIST, 'page', {
             root: true
          });
        },
        (errors) => {
          commit(INFOS_MODAL_INSERT_INFO_FAILED, AppConfig.comInsertNoFail);
          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },

    [ACTION_SET_IMAGE]({
      commit
    }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile);
    },

    [ACTION_RESET_NOTIFICATION_INFO]({ commit }, values) {
      commit(INFOS_MODAL_INSERT_INFO_SUCCESS, values);
    }
  }
}