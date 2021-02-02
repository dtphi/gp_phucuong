import axios from 'axios';
import { 
  NEWS_MODAL_SET_OPEN_MODAL, 
  NEWS_MODAL_SET_CLOSE_MODAL, 
  NEWS_MODAL_SET_IS_OPEN_MODAL,
  NEWS_MODAL_SET_NEWS_ID,
  NEWS_MODAL_SET_NEWS,
  NEWS_MODAL_SET_LOADING,
  NEWS_MODAL_INSERT_NEWS_SUCCESS,
  NEWS_MODAL_UPDATE_NEWS_SUCCESS,
  NEWS_MODAL_INSERT_NEWS_FAILED,
  NEWS_MODAL_UPDATE_NEWS_FAILED,
  NEWS_MODAL_SET_ERROR 
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
    		[NEWS_MODAL_SET_OPEN_MODAL](state, payload) {
    			state.action = payload;
    			state.classShow = 'modal fade show';
    			state.styleCss = 'display:block';
    		},

    		[NEWS_MODAL_SET_CLOSE_MODAL](state) {
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

        [NEWS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
            state.isOpen = payload
        },

        [NEWS_MODAL_SET_NEWS_ID](state, payload) {
        	state.userId = payload
        },

        [NEWS_MODAL_SET_NEWS](state, payload) {
        	state.user = payload
        },

        [NEWS_MODAL_SET_LOADING](state, payload) {
        	state.loading = payload
        },

        [NEWS_MODAL_INSERT_NEWS_SUCCESS](state, payload) {

        },

        [NEWS_MODAL_UPDATE_NEWS_SUCCESS](state, payload) {
        	
        },

        [NEWS_MODAL_SET_ERROR](state, payload) {
          state.errors = payload
        }
    },

    actions: {
        showModal ({ dispatch, commit }, actionName) {
        	commit(NEWS_MODAL_SET_OPEN_MODAL, actionName);

        	dispatch('isOpenModal', true);
        },

        showModalEdit ({ dispatch, commit }, userId) {
        	commit(NEWS_MODAL_SET_NEWS_ID, userId);
        	commit(NEWS_MODAL_SET_OPEN_MODAL, 'edit');

        	dispatch('getUserById', userId)
        	dispatch('isOpenModal', true);
        },

        getUserById ({commit}, userId) {
        	const user = {id:1,name:'Phi', email: 'dtphi.khtn@gmail.com', createAt: '02/02/2021'};
        	commit(NEWS_MODAL_SET_NEWS, user);
        },

        closeModal ({ dispatch, commit }) {
        	commit(NEWS_MODAL_SET_CLOSE_MODAL);

        	dispatch('isOpenModal', false);
        },

        isOpenModal ({commit}, payload) {
        	commit(NEWS_MODAL_SET_IS_OPEN_MODAL, payload);
        },

        setLoading ({commit} , isLoading) {
        	commit('NEWS_MODAL_SET_LOADING', isLoading);
        },

        insertUser ({ dispatch, commit }, user) {
        	setTimeout(() => {
        		commit(NEWS_MODAL_INSERT_NEWS_SUCCESS, 'insert success')
        		commit(NEWS_MODAL_SET_LOADING, false)
        		dispatch('closeModal')
        	}, 3 * 1000)
        },

        updateUser ({ dispatch, commit }, user) {
        	setTimeout(() => {
        		commit(NEWS_MODAL_UPDATE_NEWS_SUCCESS, 'update success')
        		commit(NEWS_MODAL_SET_LOADING, false)
        		dispatch('closeModal')
        	}, 3 * 1000)
        }
    }
}
