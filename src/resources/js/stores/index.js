import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

import adminAuth from './admin/auth.module';
import adminMessages from './admin/messages.module';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoading: false,
        errorMessages: null,
        token: null,
        passwordLastChangedAt: null
    },
    getters: {
        isLoading: state => state.isLoading,
        errorMessages: state => state.errorMessages,
        token: state => state.token,
        passwordLastChangedAt: state => state.passwordLastChangedAt
    },
    mutations: {
        START_LOADING(state) {
            state.isLoading = true;
        },
        STOP_LOADING(state) {
            state.isLoading = false;
        },
        SET_ERRORS(state, data) {
            if (data && data.extend) {
                state.errorMessages = state.errorMessages ? { ...state.errorMessages, ...data.errors } : data.errors;
            } else {
                state.errorMessages = data;
            }
        },
        SET_TOKEN(state, data) {
            state.token = data;
        },
        SET_PASSWORD_LAST_CHANGED_AT(state, data) {
            state.passwordLastChangedAt = data;
        }
    },
    modules: {
        'admin.auth': adminAuth,
        'admin.messages': adminMessages
    },
    plugins: [ createPersistedState() ]
});