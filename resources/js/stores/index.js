import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

import adminAuth from './admin/auth.module';
import adminMessages from './admin/messages.module';
import adminRepresentatives from './admin/representatives.module';
import adminStores from './admin/stores.module';
import representativeAuth from './representative/auth.module';
import representativeMessages from './representative/messages.module';
import storeAuth from './store/auth.module';
import storeMessages from './store/messages.module';
import storeCatalog from './store/catalog.module';
import storeHistory from './store/history.module';

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
        'admin.messages': adminMessages,
        'admin.representatives': adminRepresentatives,
        'admin.stores': adminStores,
        'representative.auth': representativeAuth,
        'representative.messages': representativeMessages,
        'store.auth': storeAuth,
        'store.messages': storeMessages,
        'store.catalog': storeCatalog,
        'store.history': storeHistory
    },
    plugins: [ createPersistedState() ]
});