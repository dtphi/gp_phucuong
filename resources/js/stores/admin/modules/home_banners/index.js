import AppConfig from 'api@admin/constants/app-config';
import {
  apiGetSettingByCode,
  apiInsertSetting
} from 'api@admin/setting';
import {
  INFOS_FORM_SET_MAIN_IMAGE,
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SET_KEYS_DATA,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  MODULE_UPDATE_SET_ERROR
} from '../../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_SET_IMAGE,
  ACTION_GET_SETTING,
  ACTION_RESET_NOTIFICATION_INFO
} from '../../types/action-types';

const defaultState = () => {
  return {
    banner_image: '',
    title_on_goi: '',
    img_on_goi: '',
    url_on_goi: '',
    sort_on_goi: '',
    title_loi_chua: '',
    img_loi_chua: '',
    url_loi_chua: '',
    sort_loi_chua: '',
    title_video: '',
    img_video: '',
    url_video: '',
    sort_video: '',
    title_audio_podcast: '',
    img_audio_podcast: '',
    url_audio_podcast: '',
    sort_audio_podcast: '',
    title_linh_muc: '',
    img_linh_muc: '',
    url_linh_muc: '',
    sort_linh_muc: '',
    title_giao_xu: '',
    img_giao_xu: '',
    url_giao_xu: '',
    sort_giao_xu: '',
    title_thong_bao: '',
    img_thong_bao: '',
    url_thong_bao: '',
    sort_thong_bao: '',
    title_phung_vu: '',
    img_phung_vu: '',
    url_phung_vu: '',
    sort_phung_vu: '',
    loading: false,
    updateSuccess: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    banners(state) {
      return state
    },
    updateSuccess(state) {
      return state.updateSuccess
    }
  },
  mutations: {
    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state[payload.type] = payload.path;
    },
    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
    },
    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      if (payload.hasOwnProperty('module_banner_audio_podcasts')) {
        state.img_audio_podcast = payload.module_banner_audio_podcasts.value.image;
        state.title_audio_podcast = payload.module_banner_audio_podcasts.value.title;
        state.url_audio_podcast = payload.module_banner_audio_podcasts.value.url;
        state.sort_audio_podcast = payload.module_banner_audio_podcasts.value.sort;
      }
      if (payload.hasOwnProperty('module_banner_giao_xus')) {
        state.img_giao_xu = payload.module_banner_giao_xus.value.image;
        state.title_giao_xu = payload.module_banner_giao_xus.value.title;
        state.url_giao_xu = payload.module_banner_giao_xus.value.url;
        state.sort_giao_xu = payload.module_banner_giao_xus.value.sort;
      }
      if (payload.hasOwnProperty('module_banner_linh_mucs')) {
        state.img_linh_muc = payload.module_banner_linh_mucs.value.image;
        state.title_linh_muc = payload.module_banner_linh_mucs.value.title;
        state.url_linh_muc = payload.module_banner_linh_mucs.value.url;
        state.sort_linh_muc = payload.module_banner_linh_mucs.value.sort;
      }
      if (payload.hasOwnProperty('module_banner_loi_chuas')) {
        state.img_loi_chua = payload.module_banner_loi_chuas.value.image;
        state.title_loi_chua = payload.module_banner_loi_chuas.value.title;
        state.url_loi_chua = payload.module_banner_loi_chuas.value.url;
        state.sort_loi_chua = payload.module_banner_loi_chuas.value.sort;
      }

      if (payload.hasOwnProperty('module_banner_on_gois')) {
        state.img_on_goi = payload.module_banner_on_gois.value.image;
        state.title_on_goi = payload.module_banner_on_gois.value.title;
        state.url_on_goi = payload.module_banner_on_gois.value.url;
        state.sort_on_goi = payload.module_banner_on_gois.value.sort;
      }
      if (payload.hasOwnProperty('module_banner_phung_vus')) {
        state.img_phung_vu = payload.module_banner_phung_vus.value.image;
        state.title_phung_vu = payload.module_banner_phung_vus.value.title;
        state.url_phung_vu = payload.module_banner_phung_vus.value.url;
        state.sort_phung_vu = payload.module_banner_phung_vus.value.sort;
      }
      if (payload.hasOwnProperty('module_banner_thong_baos')) {
        state.img_thong_bao = payload.module_banner_thong_baos.value.image;
        state.title_thong_bao = payload.module_banner_thong_baos.value.title;
        state.url_thong_bao = payload.module_banner_thong_baos.value.url;
        state.sort_thong_bao = payload.module_banner_thong_baos.value.sort;
      }
      if (payload.hasOwnProperty('module_banner_videos')) {
        state.img_video = payload.module_banner_videos.value.image;
        state.title_video = payload.module_banner_videos.value.title;
        state.url_video = payload.module_banner_videos.value.url;
        state.sort_video = payload.module_banner_videos.value.sort;
      }
    },
    [MODULE_UPDATE_SETTING_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SETTING_FAILED](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SET_ERROR](state, payload) {
      state.errors = payload
    },
  },
  actions: {
    [ACTION_GET_SETTING]({
      dispatch,
      state,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetSettingByCode(
        "module_banner",
        (res) => {
          if (Object.keys(res.data.results).length) {
            commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.results);

            dispatch(ACTION_SET_LOADING, false);
          } else {
            dispatch(ACTION_SET_LOADING, false);
          }
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false);
        }
      );
    },
    [ACTION_SET_IMAGE]({
      commit
    }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile);
    },
    ACTION_UPDATE_BANNER({ commit, state, dispatch }) {
      dispatch(ACTION_SET_LOADING, true);
      const data = {
        action: 'update',
        code: 'module_banner',
        keys: [
          {
            key: 'module_banner_on_gois',
            value: {
              image: state.img_on_goi,
              title: state.title_on_goi,
              url: state.url_on_goi,
              sort: state.sort_on_goi
            },
            serialize: true
          },
          {
            key: 'module_banner_loi_chuas',
            value: {
              image: state.img_loi_chua,
              title: state.title_loi_chua,
              url: state.url_loi_chua,
              sort: state.sort_loi_chua
            },
            serialize: true
          },
          {
            key: 'module_banner_videos',
            value: {
              image: state.img_video,
              title: state.title_video,
              url: state.url_video,
              sort: state.sort_video
            },
            serialize: true
          },
          {
            key: 'module_banner_audio_podcasts',
            value: {
              image: state.img_audio_podcast,
              title: state.title_audio_podcast,
              url: state.url_audio_podcast,
              sort: state.sort_audio_podcast
            },
            serialize: true
          },
          {
            key: 'module_banner_linh_mucs',
            value: {
              image: state.img_linh_muc,
              title: state.title_linh_muc,
              url: state.url_linh_muc,
              sort: state.sort_linh_muc
            },
            serialize: true
          },
          {
            key: 'module_banner_giao_xus',
            value: {
              image: state.img_giao_xu,
              title: state.title_giao_xu,
              url: state.url_giao_xu,
              sort: state.sort_giao_xu
            },
            serialize: true
          },
          {
            key: 'module_banner_thong_baos',
            value: {
              image: state.img_thong_bao,
              title: state.title_thong_bao,
              url: state.url_thong_bao,
              sort: state.sort_thong_bao
            },
            serialize: true
          },
          {
            key: 'module_banner_phung_vus',
            value: {
              image: state.img_phung_vu,
              title: state.title_phung_vu,
              url: state.url_phung_vu,
              sort: state.sort_phung_vu
            },
            serialize: true
          }
        ]
      }

      apiInsertSetting(
        data,
        (result) => {
          commit(MODULE_UPDATE_SETTING_SUCCESS, AppConfig.comInsertNoSuccess);
          commit(MODULE_UPDATE_SET_ERROR, []);

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(MODULE_UPDATE_SETTING_FAILED, AppConfig.comInsertNoFail);
          commit(MODULE_UPDATE_SET_ERROR, errors);

          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },
    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(MODULE_UPDATE_SET_LOADING, isLoading);
    },
    [ACTION_RESET_NOTIFICATION_INFO]({
      commit
    }, values) {
      commit(MODULE_UPDATE_SETTING_SUCCESS, values)
    },
  },
}