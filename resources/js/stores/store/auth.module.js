import * as Mutation from '../mutation.types';
import * as API from '../API';

const SET_STORE = 'SET_STORE';
const LOGOUT = 'LOGOUT';

const state = {
    store: null,
    isAuthenticated: false
};

const getters = {
    store: state => state.store,
    isAuthenticated: state => state.isAuthenticated,
    storeCode: state => state.store ? state.store.code : null
};

const mutations = {
    [SET_STORE](state, payload) {
        state.store = payload;
        state.isAuthenticated = true;
    },
    [LOGOUT](state) {
        state.store = null;
        state.isAuthenticated = false;
    }
};

const actions = {
    async login({ commit }, data) {
        const responseLogin = await axios.post(API.API_STORE_AUTH_LOGIN, data);

        if (responseLogin.status === 200) {
            if (responseLogin.data.status === 200) {
                await commit(Mutation.SET_TOKEN, responseLogin.data.data.access_token, { root: true });

                const responseStore = await axios.get(API.API_STORE_AUTH_STORE);

                await commit(SET_STORE, responseStore.data.data.store);

                await commit(Mutation.SET_PASSWORD_LAST_CHANGED_AT, responseStore.data.data.store.password_last_changed_at, { root: true });
            } else {
                await commit(Mutation.SET_ERRORS, responseLogin.data.errors, { root: true });
            }
            return responseLogin.data.status;
        }
        return responseLogin.status;
    },
    async refresh({ commit }) {
        const responseRefresh = await axios.get(API.API_STORE_AUTH_REFRESH);

        if (responseRefresh.status === 200) {
            if (responseRefresh.data.status === 200) {
                await commit(Mutation.SET_TOKEN, responseRefresh.data.data.access_token, { root: true });

                const responseStore = await axios.get(API.API_STORE_AUTH_STORE);

                await commit(SET_STORE, responseStore.data.data.store);
            } else {
                await commit(Mutation.SET_ERRORS, responseRefresh.data.errors, { root: true });
            }
            return responseRefresh.data.status;
        }
        return responseRefresh.status;
    },
    async checkDeleted({ commit }, data) {
        const response = await axios.get(API.API_STORE_AUTH_CHECK_DELETED + '/' + data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async logout({ commit }) {
        await axios.post(API.API_STORE_AUTH_LOGOUT);

        await commit(LOGOUT);
        await commit(Mutation.SET_TOKEN, null, { root: true });
        await commit(Mutation.SET_PASSWORD_LAST_CHANGED_AT, null, { root: true });
        localStorage.removeItem('vuex');
    },
    async resetPassword({ commit }, data) {
        const responseReset = await axios.post(API.API_STORE_AUTH_RESET_PASSWORD, data);

        if (responseReset.status === 200) {
            if (responseReset.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, responseReset.data.errors, { root: true });
            }
            return responseReset.data.status;
        }
        return responseReset.status;
    },
    async changePassword({ commit }, data) {
        const responseChange = await axios.post(API.API_STORE_SETTING_CHANGE_PASSWORD, data);

        if (responseChange.status === 200) {
            if (responseChange.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, responseChange.data.errors, { root: true });
            } else {
                await axios.post(API.API_STORE_AUTH_LOGOUT);

                await commit(LOGOUT);
                await commit(Mutation.SET_TOKEN, null, { root: true });
                localStorage.removeItem('vuex');
            }

            return responseChange.data.status;
        }
        return responseChange.status;
    },
    async changeEmail({ commit }, data) {
        const responseChange = await axios.post(API.API_STORE_SETTING_CHANGE_EMAIL, data);

        if (responseChange.status === 200) {
            if (responseChange.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, responseChange.data.errors, { root: true });
            } else {
                const responseStore = await axios.get(API.API_STORE_AUTH_STORE);

                await commit(SET_STORE, responseStore.data.data.store);
            }
            return responseChange.data.status;
        }
        return responseChange.status;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};