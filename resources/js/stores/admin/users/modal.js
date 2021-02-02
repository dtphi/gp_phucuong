import axios from 'axios';
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

        },

        [USERS_MODAL_UPDATE_USER_SUCCESS](state, payload) {
        	
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

        	dispatch('getUserById', userId)
        	dispatch('isOpenModal', true);
        },

        getUserById ({commit}, userId) {
        	const user = {id:1,name:'Phi', email: 'dtphi.khtn@gmail.com', createAt: '02/02/2021'};
        	commit(USERS_MODAL_SET_USER, user);
        },

        closeModal ({ dispatch, commit }) {
        	commit(USERS_MODAL_SET_CLOSE_MODAL);

        	dispatch('isOpenModal', false);
        },

        isOpenModal ({commit}, payload) {
        	commit(USERS_MODAL_SET_IS_OPEN_MODAL, payload);
        },

        setLoading ({commit} , isLoading) {
        	commit('USERS_MODAL_SET_LOADING', isLoading);
        },

        insertUser ({ dispatch, commit }, user) {
        	setTimeout(() => {
        		commit(USERS_MODAL_INSERT_USER_SUCCESS, 'insert success')
        		commit(USERS_MODAL_SET_LOADING, false)
        		dispatch('closeModal')
        	}, 3 * 1000)
        },

        updateUser ({ dispatch, commit }, user) {
        	setTimeout(() => {
        		commit(USERS_MODAL_UPDATE_USER_SUCCESS, 'update success')
        		commit(USERS_MODAL_SET_LOADING, false)
        		dispatch('closeModal')
        	}, 3 * 1000)
        }
    }
}
