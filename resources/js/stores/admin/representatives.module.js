import * as Mutation from '../mutation.types';
import * as API from '../API';

const SET_REPRESENTATIVE = 'SET_REPRESENTATIVE';
const SET_DEALERS = 'SET_DEALERS';

const state = {
    representative: null,
    dealers: []
};

const getters = {
    representative: state => state.representative,
    dealers: state => state.dealers
};

const mutations = {
    [SET_REPRESENTATIVE](state, payload) {
        state.representative = payload;
    },
    [SET_DEALERS](state, payload) {
        state.dealers = payload;
    }
};

const actions = {
    async create({ commit }, data) {
        const response = await axios.post(API.API_ADMIN_REPRESENTATIVES_CREATE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async checkDeleted({ commit }, data) {
        const response = await axios.get(API.API_ADMIN_REPRESENTATIVES_CHECK_DELETED + '/' + data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async checkValidated({ commit }, data) {
        const response = await axios.post(API.API_ADMIN_REPRESENTATIVES_CHECK_VALIDATED, data);

        if (response.status === 200) {
            const errors = {
                extend: true,
                errors: {
                    employeeNumber: null,
                    mainEmail: null,
                    subEmail1: null,
                    subEmail2: null,
                    subEmail3: null,
                    subEmail4: null
                }
            };

            if (response.data.status !== 200) {
                errors.errors = { ...errors.errors, ...response.data.errors };
            }
            await commit(Mutation.SET_ERRORS, errors, { root: true });

            return response.data.status;
        }
        return response.status;
    },
    async show({ commit }, data) {
        const response = await axios.get(API.API_ADMIN_REPRESENTATIVES_SHOW + '/' + data);

        if (response.status === 200) {
            if (response.data.status === 200) {
                await commit(SET_REPRESENTATIVE, response.data.data.representative);
                await commit(SET_DEALERS, response.data.data.dealers);
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async update({ commit }, data) {
        const response = await axios.put(API.API_ADMIN_REPRESENTATIVES_UPDATE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async resetPassword({ commit }, data) {
        const response = await axios.put(API.API_ADMIN_REPRESENTATIVES_RESET_PASSWORD, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async delete({ commit }, data) {
        const response = await axios.delete(API.API_ADMIN_REPRESENTATIVES_DELETE + '/' + data);

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