import axios from 'axios';
import { 
  USERS_MODAL_SET_OPEN_MODAL, 
  USERS_MODAL_SET_CLOSE_MODAL, 
  USERS_MODAL_SET_IS_OPEN_MODAL,
  USERS_MODAL_SET_ERROR 
} from '../mutation-types';

export default {
    namespaced: true,
    state: {
      isOpen: false,
      action: null,
      classShow: 'modal fade',
      styleCss: '',
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
    			state.action = null;
    			state.classShow = 'modal fade';
    			state.styleCss = 'display:none';
    		},

        [USERS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
            state.isOpen = payload
        },

        [USERS_MODAL_SET_ERROR](state, payload) {
          state.errors = payload
        }
    },

    actions: {
        showModal ({ dispatch, commit }, payload) {
        	commit(USERS_MODAL_SET_OPEN_MODAL, payload);
        	dispatch('isOpenModal', true);
        },

        closeModal ({ dispatch, commit }) {
        	commit(USERS_MODAL_SET_CLOSE_MODAL);
        	dispatch('isOpenModal', false);
        },

        isOpenModal ({commit}, payload) {
        	commit(USERS_MODAL_SET_IS_OPEN_MODAL, payload);
        }
    }
}
