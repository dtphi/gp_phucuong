import * as Mutation from '../mutation.types';
import * as API from '../API';

const state = {};

const getters = {};

const mutations = {};

const actions = {
    async getStore({ commit }, data) {
        const response = await axios.get(API.API_ADMIN_MESSAGES_GET_STORE + '/' + data);

        if (response.status === 200) {
            let store = null;

            if (response.data.status === 200) {
                store = response.data.data.store;
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return {
                status: response.data.status,
                store
            };
        }
        return response.status;
    },
    async getMessage({ commit }, data) {
        const response = await axios.get(API.API_ADMIN_MESSAGES_GET_MESSAGE + '?' + data);

        if (response.status === 200) {
            let message = null;

            if (response.data.status === 200) {
                message = response.data.data.message;
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return {
                status: response.data.status,
                message
            };
        }
        return response.status;
    },
    async getMessages({ commit }, data) {
        const response = await axios.get(API.API_ADMIN_MESSAGES_GET_MESSAGES + '?' + data);

        if (response.status === 200) {
            let messages = null;

            if (response.data.status === 200) {
                messages = response.data.data.messages;
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return {
                status: response.data.status,
                messages
            };
        }
        return response.status;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};