import AppConfig from 'api@admin/constants/app-config';
import adds from './add';
import edits from './edit';
import {
  apiGetInfoById,
  apiGetGiaoHatInfos,
  apiDeleteInfo,
  apiSearchAll,
  apiGetSlideSpecialInfos
} from 'api@admin/thanh';
import {
  apiGetSettingByCode,
  apiInsertSetting
} from 'api@admin/setting';
import {
  MODULE_MODULE_GIAO_HAT,
} from '../types/module-types';
import {
  INFOS_SET_LOADING,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_DELETE_INFO_BY_ID_SUCCESS,
  INFOS_DELETE_INFO_BY_ID_FAILED,
  INFOS_SET_INFO_LIST,
  INFOS_INFO_DELETE_BY_ID,
  INFOS_SET_INFO_DELETE_BY_ID_FAILED,
  INFOS_SET_INFO_DELETE_BY_ID_SUCCESS,
  INFOS_SET_ERROR,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
} from '../types/mutation-types';
import {
  ACTION_GET_INFO_LIST,
  ACTION_DELETE_INFO_BY_ID,
  ACTION_SET_INFO_DELETE_BY_ID,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_SET_LOADING,
  ACTION_SEARCH_ALL,
  ACTION_RESET_NOTIFICATION_INFO
} from '../types/action-types';
import {
  fn_redirect_url
} from '@app/api/utils/fn-helper';
import _ from 'lodash';

const defaultState = () => {
  return {
    infos: [],
    total: 0,
    infoDelete: null,
    isDelete: false,
    isList: false,
    module_special_info_ids:[],
    module_special_infos: [],
    moduleSpecialData: {
      code: 'module_special_info',
      keys: [
        {
          key: 'module_special_info_ids',
          value: [],
          serialize: true
        }
      ]
    },
    loading: false,
    updateSuccess: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    infos(state) {
      return state.infos
    },
    loading(state) {
      return state.loading
    },
    errors(state) {
      return state.errors
    },
    isError(state) {
      return state.errors.length
    }
  },

  mutations: {
    addSpecialInfoId(state, payload) {
      state.module_special_info_ids = payload;
    },
    addSepecialModuleData(state, payload) {
      state.module_special_infos = payload;
    },
    updateSpecialInfoData(state, payload) {
      state.module_special_infos = [];
      state.module_special_info_ids = [];
      state.module_special_infos = payload.module_special_info_ids.value;
      _.forEach(state.module_special_infos, function(item) {
        state.module_special_info_ids.push(item.id);
      });
      state.moduleSpecialData.keys = [];
      state.moduleSpecialData.keys.push(payload.module_special_info_ids);
    },
    [MODULE_UPDATE_SETTING_SUCCESS](state,payload) {
      state.updateSuccess = payload;
    },
    [MODULE_UPDATE_SETTING_FAILED](state,payload) {
      state.updateSuccess = payload;
    },
    [INFOS_SET_INFO_LIST](state, payload) {
      state.infos = payload
    },

    [INFOS_INFO_DELETE_BY_ID](state, payload) {
      state.infoDelete = payload
    },

    [INFOS_SET_INFO_DELETE_BY_ID_FAILED](state, payload) {
      state.isDelete = payload;
    },

    [INFOS_SET_INFO_DELETE_BY_ID_SUCCESS](state, payload) {
      state.isDelete = payload;
    },

    [INFOS_GET_INFO_LIST_SUCCESS](state, payload) {
      state.isList = payload
    },

    [INFOS_GET_INFO_LIST_FAILED](state, payload) {
      state.isList = payload
    },

    [INFOS_DELETE_INFO_BY_ID_SUCCESS](state, payload) {
      state.isDelete = payload
    },

    [INFOS_DELETE_INFO_BY_ID_FAILED](state, payload) {
      state.isDelete = false;
      state.errors = payload;
    },

    [INFOS_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [INFOS_SET_ERROR](state, payload) {
      state.errors = payload
    }
  },

  actions: {
    addSpecial({commit, state},data) {
      let infos = state.module_special_info_ids;
      let values = state.module_special_infos;
      console.log(data)
      if (data.isChecked) {
        console.log('add')
        infos.push(data.info.information_id);

        values.push({
          id: data.info.information_id,
          img: data.info.image.path
        });
      } else {
        console.log('remove')
        _.remove(infos, function (itemId) {
            return !(parseInt(itemId) - parseInt(data.info.information_id));
        });
        _.remove(values, function (item) {
            return !(parseInt(item.id) - parseInt(data.info.information_id));
        });
      }

      commit('addSpecialInfoId', infos);
      commit('addSepecialModuleData', values);
    },
    get_module_special_info_ids({dispatch,commit,state}) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetSettingByCode(
        state.moduleSpecialData.code,
        (res) => {
          if (Object.keys(res.data.results).length) {
            commit('updateSpecialInfoData', res.data.results);

            dispatch('ACTION_GET_SLIDE_SPECIAL_INFO_LIST', {
              infoType: 'module_special_info',
              infoIds: res.data.results.module_special_info_ids.value
            })
          } else {
            dispatch(ACTION_SET_LOADING, false);
          }
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },
    module_special_info_ids({dispatch, commit,state}, value) {
      const moduleData = {
        code: 'module_special_info',
        keys: [
          {
            key: 'module_special_info_ids',
            value: state.module_special_infos,
            serialize: true
          }
        ]
      }
      if (state.module_special_infos.length) {
        dispatch(ACTION_SET_LOADING, true);
        apiInsertSetting(
          moduleData,
          (result) => {
            commit(MODULE_UPDATE_SETTING_SUCCESS, AppConfig.comInsertNoSuccess);
            commit(INFOS_SET_ERROR, []);
  
            dispatch(ACTION_SET_LOADING, false);
          },
          (errors) => {
            commit(MODULE_UPDATE_SETTING_FAILED, AppConfig.comInsertNoFail);
            commit(INFOS_SET_ERROR, errors);
  
            dispatch(ACTION_SET_LOADING, false);
          }
        )
      }
    },
    async [ACTION_GET_INFO_LIST]({
      dispatch,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      await apiGetGiaoHatInfos(
        (infos) => {
          console.log(infos)
          commit(INFOS_SET_INFO_LIST, infos.data.results);
          commit(INFOS_GET_INFO_LIST_SUCCESS, true)

          var pagination = {
            current_page: 1,
            total: 0
          };
          if (infos.data.hasOwnProperty('pagination')) {
            pagination = infos.data.pagination;
          }
          var configs = {
            moduleActive: {
              name: MODULE_MODULE_GIAO_HAT,
              actionList: ACTION_GET_INFO_LIST
            },
            collectionData: pagination
          };

          dispatch('setConfigApp', configs, {
            root: true
          });
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, errors)
        },
        params
      );
      dispatch(ACTION_SET_LOADING, false);
    },

    async [ACTION_DELETE_INFO_BY_ID]({
      state,
      dispatch,
      commit
    }, infoId) {
      let getId = null;
      if (typeof state.infoDelete === "object") {
        if (state.infoDelete.hasOwnProperty('information_id')) {
          getId = parseInt(state.infoDelete.information_id);
        }
      }
      const deleteId = parseInt(infoId);

      if (getId === deleteId) {
        await apiDeleteInfo(
          deleteId,
          (infos) => {
            commit(INFOS_DELETE_INFO_BY_ID_SUCCESS, true);
            dispatch(ACTION_GET_INFO_LIST);
            commit(INFOS_INFO_DELETE_BY_ID, null);
          },
          (errors) => {
            commit(INFOS_DELETE_INFO_BY_ID_FAILED, false);
            if (errors) {
              commit(INFOS_SET_ERROR, errors);
            }
          }
        );
      }
    },

    [ACTION_SET_INFO_DELETE_BY_ID]({
      commit
    }, infoId) {
      apiGetInfoById(
        infoId,
        (result) => {
          commit(INFOS_INFO_DELETE_BY_ID, result.data);
          commit(INFOS_SET_INFO_DELETE_BY_ID_SUCCESS, true);
        },
        (errors) => {
          commit(INFOS_SET_INFO_DELETE_BY_ID_FAILED, false);
          if (errors) {
            commit(INFOS_SET_ERROR, errors);
          }
        }
      );
    },

    [ACTION_RELOAD_GET_INFO_LIST]: {
      root: true,
      handler(namespacedContext, payload) {
        if (isNaN(payload)) {
          return fn_redirect_url('admin/informations');
        } else {
          namespacedContext.dispatch(ACTION_GET_INFO_LIST);
        }
      }
    },

    [ACTION_SET_LOADING]({
      commit
    }, isLoading) {
      commit(INFOS_SET_LOADING, isLoading);
    },

    [ACTION_SEARCH_ALL]({
      dispatch,
      commit
    }, query) {
      dispatch(ACTION_SET_LOADING, true);
      apiSearchAll(query,
        (result) => {
          commit(INFOS_GET_INFO_LIST_SUCCESS, true);
          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, false);
          dispatch(ACTION_SET_LOADING, false);
        }
      )
    },
    [ACTION_RESET_NOTIFICATION_INFO]({
      commit
    }, values) {
      commit(MODULE_UPDATE_SETTING_SUCCESS, values);
    },

    ACTION_GET_SLIDE_SPECIAL_INFO_LIST({
      dispatch,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetSlideSpecialInfos(
        (infos) => {
          commit(INFOS_SET_INFO_LIST, infos.data.results);
          commit(INFOS_GET_INFO_LIST_SUCCESS, true)

          var pagination = {
            current_page: 1,
            total: 0
          };
          if (infos.data.hasOwnProperty('pagination')) {
            pagination = infos.data.pagination;
          }
          var configs = {
            moduleActive: {
              name: MODULE_MODULE_GIAO_HAT,
              actionList: ACTION_GET_INFO_LIST
            },
            collectionData: pagination
          };

          dispatch('setConfigApp', configs, {
            root: true
          });

          dispatch(ACTION_SET_LOADING, false);
        },
        (errors) => {
          commit(INFOS_GET_INFO_LIST_FAILED, errors);

          dispatch(ACTION_SET_LOADING, false);
        },
        params
      );
    },
  },

  modules: {
    add: adds,
    edit: edits
  }
}