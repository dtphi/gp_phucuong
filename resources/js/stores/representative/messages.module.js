import * as Mutation from '../mutation.types';
import * as API from '../API';

const SET_UNREAD = 'SET_UNREAD';

const state = {
    unread: 0,
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
    async getStores({ commit }, data) {
        const response = await axios.get(API.API_REPRESENTATIVE_MESSAGES_GET_STORES + '/' + data);

        if (response.status === 200) {
            let stores = null;

            if (response.data.status === 200) {
                stores = response.data.data.stores;
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return {
                status: response.data.status,
                stores
            };
        }
        return response.status;
    },
    async getMessage({ commit }, data) {
        const response = await axios.get(API.API_REPRESENTATIVE_MESSAGES_GET_MESSAGE + '?' + data);

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
        const response = await axios.get(API.API_REPRESENTATIVE_MESSAGES_GET_MESSAGES + '?' + data);

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
        const response = await axios.get(API.API_REPRESENTATIVE_MESSAGES_COUNT_UNREAD + '?' + data);

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
        const response = await axios.put(API.API_REPRESENTATIVE_MESSAGES_MARK_SEEN, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async create({ commit }, data) {
        const response = await axios.post(API.API_REPRESENTATIVE_MESSAGES_SEND_MESSAGE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async update({ commit }, data) {
        const response = await axios.post(API.API_REPRESENTATIVE_MESSAGES_EDIT_MESSAGE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async sendToSubEmails({ commit }, data) {
        const response = await axios.post(API.API_REPRESENTATIVE_MESSAGES_SEND_TO_SUB_EMAILS, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async delete({ commit }, data) {
        const response = await axios.delete(API.API_REPRESENTATIVE_MESSAGES_DELETE_MESSAGE + '/' + data);

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