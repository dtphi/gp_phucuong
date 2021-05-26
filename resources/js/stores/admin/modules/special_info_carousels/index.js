import AppConfig from 'api@admin/constants/app-config';
import { v4 as uuidv4 } from 'uuid';
import {
  apiGetSettingByCode,
  apiInsertSetting
} from 'api@admin/setting';
import {
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  MODULE_UPDATE_SET_ERROR,
  MODULE_UPDATE_SET_KEYS_DATA,
} from '../../types/mutation-types';
import {
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_INSERT_SETTING,
  ACTION_GET_SETTING,
} from '../../types/action-types';
import _ from 'lodash';

const specialInfoCarousel = {
  value: []
}

const defaultState = () => {
  return {
    specialInfoCarousel: specialInfoCarousel,
    loading: false,
    updateSuccess: false,
    errors: []
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    specialInfoCarousel(state) {
      return state.specialInfoCarousel;
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
    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
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
    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      if (payload.hasOwnProperty('specialInfoCarousel')) {
        state.specialInfoCarousel = payload.specialInfoCarousel;
      }
      state.specialInfoCarousel.value = _.forEach(state.specialInfoCarousel.value, function(item) {
        if (!item.hasOwnProperty('id')) {
          _.update(item, 'id', function(id) {
            return id = uuidv4();
          })
        }
        if (!item.hasOwnProperty('status')) {
          _.update(item, 'status', function(id) {
            return status = 1;
          })
        }
        if (!item.hasOwnProperty('open')) {
          _.update(item, 'open', function(id) {
            return open = 0;
          })
        }
      });
    }
  },

  actions: {
    pushSpecialInfoCarousel({state}, value) {
      const data = {
        id: uuidv4(),
        status: 1,
        open: 0,
        image: value.filePath,
        width: 700,
        height: 150
      };
      state.specialInfoCarousel.value.push(data);
    },
    specialInfoCarouselRemove({state}, banner) {
      let banners = state.specialInfoCarousel.value;
      if(state.specialInfoCarousel.value.length > 1) {
        state.specialInfoCarousel.value = _.remove(banners, function(item) {
          return !(item.id == banner.id);
        })
      }
    },
    [ACTION_GET_SETTING]({
      dispatch,
      state,
      commit
    }, params) {
      dispatch(ACTION_SET_LOADING, true);
      apiGetSettingByCode(
        state.infoId,
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
    [ACTION_INSERT_SETTING]({
      commit,
      dispatch
    }, settingData) {
      console.log(settingData)
      dispatch(ACTION_SET_LOADING, true);
      apiInsertSetting(
        settingData,
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
  }
}