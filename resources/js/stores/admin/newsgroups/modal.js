import axios from 'axios';
import {
  apiGetNewsGroupById, 
  apiUpdateNewsGroup, 
  apiInsertNewsGroup
} from 'api@admin/newsgroups';
import { 
  NEWSGROUPS_MODAL_SET_OPEN_MODAL, 
  NEWSGROUPS_MODAL_SET_CLOSE_MODAL, 
  NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP,
  NEWSGROUPS_MODAL_SET_LOADING,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED,
  NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_FAILED,
  NEWSGROUPS_MODAL_SET_NEWS_GROUP_SUCCESS,
  NEWSGROUPS_MODAL_SET_ERROR 
} from '../types/mutation-types';
import {
  ACTION_GET_NEWS_GROUP_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_CLOSE_MODAL,
  ACTION_IS_OPEN_MODAL,
  ACTION_INSERT_NEWS_GROUP,
  ACTION_UPDATE_NEWS_GROUP,
  ACTION_RELOAD_GET_NEWS_GROUP_LIST
} from '../types/action-types';
const NEWS_GROUP = {
  id: null,
  name: ''
}

export default {
    namespaced: true,
    state: {
      isOpen: false,
      action: null,
      classShow: 'modal fade',
      styleCss: '',
      newsGroup: NEWS_GROUP,
      parentInfo: NEWS_GROUP,
      newsGroupAdd: NEWS_GROUP,
      newsGroupId: 0,
      itemRoot: 0,
      loading: false,
      updateSuccess: false,
      errors: []
    },
    getters: {
    	newsGroupAdd(state) {
    		return state.newsGroupAdd
    	},
      isOpen(state) {
        return state.isOpen
      },
      action(state) {
      	return state.action
      },
      classShow(state) {
      	return state.classShow
      },
      styleCss(state) {
      	return state.styleCss
      },
      newsGroup(state) {
      	return state.newsGroup
      },
      parentInfo(state) {
      	return state.parentInfo
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
    		[NEWSGROUPS_MODAL_SET_OPEN_MODAL](state, payload) {
    			state.action = payload;
    			state.classShow = 'modal fade show';
    			state.styleCss = 'display:block';
          state.updateSuccess = false;
          state.newsGroup = NEWS_GROUP;
      		state.parentInfo = NEWS_GROUP;
      		state.newsGroupId = 0;
    		},

    		[NEWSGROUPS_MODAL_SET_CLOSE_MODAL](state) {
    			if (state.action === 'add') {
    				state.action = 'close_modal';
	    			state.classShow = 'modal fade';
	    			state.styleCss = 'display:none';
	    			state.parentInfo = NEWS_GROUP;
      			state.newsGroupId = 0;
    			} else {
    				state.action = 'close_modal';
	    			state.classShow = 'modal fade';
	    			state.styleCss = 'display:none';
	    			state.newsGroupId = 0;
	    			state.newsGroup = NEWS_GROUP;
    			}
    		},

        [NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL](state, payload) {
            state.isOpen = payload
        },

        [NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID](state, payload) {
        	state.newsGroupId = payload
        },

        [NEWSGROUPS_MODAL_SET_NEWS_GROUP_FAILED](state, payload) {

        },

        [NEWSGROUPS_MODAL_SET_NEWS_GROUP_SUCCESS](state, payload) {
        	
        },

        [NEWSGROUPS_MODAL_SET_NEWS_GROUP](state, payload) {
        	if (state.action === 'add') {
        		state.parentInfo = payload
        	} else {
        		state.newsGroup = payload
        	}
        },

        [NEWSGROUPS_MODAL_SET_LOADING](state, payload) {
        	state.loading = payload
        },

        [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS](state, payload) {
          state.updateSuccess = payload;
        },

        [NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED](state, payload) {
          state.updateSuccess = payload
        },

        [NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS](state, payload) {
        	state.updateSuccess = payload
        },

        [NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED](state, payload) {
          state.updateSuccess = payload
        },

        [NEWSGROUPS_MODAL_SET_ERROR](state, payload) {
          state.errors = payload
        }
    },

    actions: {
        [ACTION_SHOW_MODAL] ({ state, dispatch, commit }, payload) {
          state.itemRoot = payload.itemRoot;
        	commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID, payload.groupId);
        	commit(NEWSGROUPS_MODAL_SET_OPEN_MODAL, payload.action);

        	dispatch(ACTION_GET_NEWS_GROUP_BY_ID, payload.groupId);
        },

        [ACTION_SHOW_MODAL_EDIT] ({ dispatch, commit }, payload) {
        	commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_ID, payload.groupId);
        	commit(NEWSGROUPS_MODAL_SET_OPEN_MODAL, payload.action);

        	dispatch(ACTION_GET_NEWS_GROUP_BY_ID, payload.groupId);
        },

        [ACTION_GET_NEWS_GROUP_BY_ID] ({dispatch, commit}, newsGroupId) {
          dispatch(ACTION_SET_LOADING, true);
          apiGetNewsGroupById(
            newsGroupId,
            (result) => {
            	commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_SUCCESS, true)
              commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP, result.data);

              dispatch(ACTION_SET_LOADING, false);
              dispatch(ACTION_IS_OPEN_MODAL, true);
            },
            (errors) => {
            	commit(NEWSGROUPS_MODAL_SET_NEWS_GROUP_FAILED, errors)

              dispatch(ACTION_SET_LOADING, false);
            }
          );
        },

        [ACTION_CLOSE_MODAL] ({ dispatch, commit }) {
        	commit(NEWSGROUPS_MODAL_SET_CLOSE_MODAL);

        	dispatch(ACTION_IS_OPEN_MODAL, false);
        },

        [ACTION_IS_OPEN_MODAL] ({commit}, payload) {
        	commit(NEWSGROUPS_MODAL_SET_IS_OPEN_MODAL, payload);
        },

        [ACTION_SET_LOADING] ({commit} , isLoading) {
        	commit(NEWSGROUPS_MODAL_SET_LOADING, isLoading);
        },

        [ACTION_INSERT_NEWS_GROUP] ({ dispatch, commit }, newsGroup) {
          apiInsertNewsGroup(
            newsGroup,
            (result) => {
              commit(NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_SUCCESS, true);

              dispatch(ACTION_RELOAD_GET_NEWS_GROUP_LIST, null, {root:true});
              dispatch(ACTION_SET_LOADING, false);
              dispatch(ACTION_CLOSE_MODAL);
            },
            (errors) => {
              commit(NEWSGROUPS_MODAL_INSERT_NEWS_GROUP_FAILED, false)

              dispatch(ACTION_SET_LOADING, false);
            }
          )
        },

        [ACTION_UPDATE_NEWS_GROUP] ({ dispatch, commit }, newsGroup) {
          apiUpdateNewsGroup(newsGroup,
            (result) => {
              commit(NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_SUCCESS, true);
              
              dispatch(ACTION_RELOAD_GET_NEWS_GROUP_LIST, null, {root:true});
              dispatch(ACTION_SET_LOADING, false);
              dispatch(ACTION_CLOSE_MODAL);
            },
            (errors) => {
              commit(NEWSGROUPS_MODAL_UPDATE_NEWS_GROUP_FAILED, errors)

              dispatch(ACTION_SET_LOADING, false);
            }
          )
        }
    }
}
