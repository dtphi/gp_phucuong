import * as Mutation from '../mutation.types';
import * as API from '../API';

const SET_UNREAD = 'SET_UNREAD';

const state = {
    unread: 0
};

const getters = {
    unread: state => state.unread
};

const mutations = {
    [SET_UNREAD](state, payload) {
        state.unread = payload;
    }
};

const actions = {
    async getEmployee({ commit }, data) {
        const response = await axios.get(API.API_STORE_MESSAGES_GET_EMPLOYEE + '/' + data);

        if (response.status === 200) {
            let employee = null;

            if (response.data.status === 200) {
                employee = response.data.data.employee;
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return {
                status: response.data.status,
                employee
            };
        }
        return response.status;
    },
    async getStore({ commit }, data) {
        const response = await axios.get(API.API_STORE_MESSAGES_GET_STORE + '/' + data);

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
        const response = await axios.get(API.API_STORE_MESSAGES_GET_MESSAGE + '?' + data);

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
        const response = await axios.get(API.API_STORE_MESSAGES_GET_MESSAGES + '?' + data);

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
    },
    async countUnread({ commit }, data) {
        const response = await axios.get(API.API_STORE_MESSAGES_COUNT_UNREAD + '?' + data);

        if (response.status === 200) {
            if (response.data.status === 200) {
                await commit(SET_UNREAD, response.data.data.unread);
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async markSeen({ commit }, data) {
        const response = await axios.put(API.API_STORE_MESSAGES_MARK_SEEN, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async create({ commit }, data) {
        const response = await axios.post(API.API_STORE_MESSAGES_SEND_MESSAGE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async update({ commit }, data) {
        const response = await axios.post(API.API_STORE_MESSAGES_EDIT_MESSAGE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async delete({ commit }, data) {
        const response = await axios.delete(API.API_STORE_MESSAGES_DELETE_MESSAGE + '/' + data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
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