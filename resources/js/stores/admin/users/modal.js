import axios from 'axios';
import ApiUser from 'api@admin/user';
import { 
  USERS_MODAL_SET_OPEN_MODAL, 
  USERS_MODAL_SET_CLOSE_MODAL, 
  USERS_MODAL_SET_IS_OPEN_MODAL,
  USERS_MODAL_SET_USER_ID,
  USERS_MODAL_SET_USER,
  USERS_MODAL_SET_LOADING,
  USERS_MODAL_INSERT_USER_SUCCESS,
  USERS_MODAL_UPDATE_USER_SUCCESS,
  USERS_MODAL_INSERT_USER_FAILED,
  USERS_MODAL_UPDATE_USER_FAILED,
  USERS_MODAL_SET_ERROR 
} from '../mutation-types';

export default {
    namespaced: true,
    state: {
      isOpen: false,
      action: null,
      classShow: 'modal fade',
      styleCss: '',
      user: null,
      userId: 0,
      loading: false,
      updateSuccess: false,
      errors: []
    },
    getters: {
      isOpen(state) {
        return state.isOpen
      },
      classShow(state) {
      	return state.classShow
      },
      styleCss(state) {
      	return state.styleCss
      },
      user(state) {
      	return state.user
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
    		[USERS_MODAL_SET_OPEN_MODAL](state, payload) {
    			state.action = payload;
    			state.classShow = 'modal fade show';
    			state.styleCss = 'display:block';
          state.updateSuccess = false;
    		},

    		[USERS_MODAL_SET_CLOSE_MODAL](state) {
    			if (state.action === 'add') {
    				state.action = null;
	    			state.classShow = 'modal fade';
	    			state.styleCss = 'display:none';
    			} else {
    				state.action = null;
	    			state.classShow = 'modal fade';
	    			state.styleCss = 'display:none';
	    			state.userId = 0;
	    			state.user = null;
    			}
    		},

        [USERS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
            state.isOpen = payload
        },

        [USERS_MODAL_SET_USER_ID](state, payload) {
        	state.userId = payload
        },

        [USERS_MODAL_SET_USER](state, payload) {
        	state.user = payload
        },

        [USERS_MODAL_SET_LOADING](state, payload) {
        	state.loading = payload
        },

        [USERS_MODAL_INSERT_USER_SUCCESS](state, payload) {
          state.updateSuccess = payload
        },

        [USERS_MODAL_INSERT_USER_FAILED](state, payload) {
          state.updateSuccess = payload
        },

        [USERS_MODAL_UPDATE_USER_SUCCESS](state, payload) {
        	state.updateSuccess = payload
        },

        [USERS_MODAL_UPDATE_USER_FAILED](state, payload) {
          state.updateSuccess = payload
        },

        [USERS_MODAL_SET_ERROR](state, payload) {
          state.errors = payload
        }
    },

    actions: {
        showModal ({ dispatch, commit }, actionName) {
        	commit(USERS_MODAL_SET_OPEN_MODAL, actionName);

        	dispatch('isOpenModal', true);
        },

        showModalEdit ({ dispatch, commit }, userId) {
        	commit(USERS_MODAL_SET_USER_ID, userId);
        	commit(USERS_MODAL_SET_OPEN_MODAL, 'edit');

        	dispatch('getUserById', userId);
        },

        async getUserById ({dispatch, commit}, userId) {
          dispatch('setLoading', true);
          await ApiUser.getUserById(
            userId,
            (result) => {
              commit(USERS_MODAL_SET_USER, result.data);
              dispatch('setLoading', false);
            }
          );
          dispatch('isOpenModal', true);
        },

        closeModal ({ dispatch, commit }) {
        	commit(USERS_MODAL_SET_CLOSE_MODAL);

        	dispatch('isOpenModal', false);
        },

        isOpenModal ({commit}, payload) {
        	commit(USERS_MODAL_SET_IS_OPEN_MODAL, payload);
        },

        setLoading ({commit} , isLoading) {
        	commit(USERS_MODAL_SET_LOADING, isLoading);
        },

        insertUser ({ dispatch, commit }, user) {
          ApiUser.insertUser(
            user,
            (result) => {
              commit(USERS_MODAL_INSERT_USER_SUCCESS, true);
              
              dispatch('setLoading', false);
              dispatch('closeModal');
            },
            (errors) => {
              commit(USERS_MODAL_INSERT_USER_FAILED, false)

              dispatch('setLoading', false);
            }
          )
        },

        updateUser ({ dispatch, commit }, user) {
          ApiUser.updateUser(user,
            (result) => {
              commit(USERS_MODAL_UPDATE_USER_SUCCESS, true);
              
              dispatch('setLoading', false);
              dispatch('closeModal');
            },
            (errors) => {
              commit(USERS_MODAL_UPDATE_USER_FAILED, false)

              dispatch('setLoading', false);
            }
          )
        }
    }
}
