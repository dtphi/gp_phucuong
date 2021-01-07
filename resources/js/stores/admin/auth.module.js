import * as Mutation from '../mutation.types';
import * as API from '../API';

const SET_ADMIN = 'SET_ADMIN';
const LOGOUT = 'LOGOUT';

const state = {
    admin: null,
    isAuthenticated: false
};

const getters = {
    admin: state => state.admin,
    isAuthenticated: state => state.isAuthenticated
};

const mutations = {
    [SET_ADMIN](state, payload) {
        state.admin = payload;
        state.isAuthenticated = true;
    },
    [LOGOUT](state) {
        state.admin = null;
        state.isAuthenticated = false;
    }
};

const actions = {
    async login({ commit }, data) {
        const responseLogin = await axios.post(API.API_ADMIN_AUTH_LOGIN, data);

        if (responseLogin.status === 200) {
            if (responseLogin.data.status === 200) {
                await commit(Mutation.SET_TOKEN, responseLogin.data.data.access_token, { root: true });

                const responseAdmin = await axios.get(API.API_ADMIN_AUTH_ADMIN);

                await commit(SET_ADMIN, responseAdmin.data.data.admin);
            } else {
                await commit(Mutation.SET_ERRORS, responseLogin.data.errors, { root: true });
            }
            return responseLogin.data.status;
        }
        return responseLogin.status;
    },
    async refresh({ commit }) {
        const responseRefresh = await axios.get(API.API_ADMIN_AUTH_REFRESH);

        if (responseRefresh.status === 200) {
            if (responseRefresh.data.status === 200) {
                await commit(Mutation.SET_TOKEN, responseRefresh.data.data.access_token, { root: true });
            } else {
                await commit(Mutation.SET_ERRORS, responseRefresh.data.errors, { root: true });
            }
            return responseRefresh.data.status;
        }
        return responseRefresh.status;
    },
    async logout({ commit }) {
        await axios.post(API.API_ADMIN_AUTH_LOGOUT);

        await commit(LOGOUT);
        await commit(Mutation.SET_TOKEN, null, { root: true });
        localStorage.removeItem('vuex');
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};