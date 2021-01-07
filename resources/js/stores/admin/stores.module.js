import * as Mutation from '../mutation.types';
import * as API from '../API';

const SET_STORE = 'SET_STORE';
const SET_EMPLOYEE = 'SET_EMPLOYEE';

const state = {
    store: null,
    employee: null
};

const getters = {
    store: state => state.store,
    employee: state => state.employee
};

const mutations = {
    [SET_STORE](state, payload) {
        state.store = payload;
    },
    [SET_EMPLOYEE](state, payload) {
        state.employee = payload;
    }
};

const actions = {
    async getEmployee({ commit }, data) {
        const response = await axios.get(API.API_ADMIN_STORES_GET_EMPLOYEE + '/' + data);

        if (response.status === 200) {
            const errors = {
                extend: true,
                errors: { employeeNumber: null }
            };
            if (response.data.status === 200) {
                await commit(SET_EMPLOYEE, response.data.data.employee);
            } else {
                errors.errors = { ...errors.errors, ...response.data.errors };
            }
            await commit(Mutation.SET_ERRORS, errors, { root: true });

            return response.data.status;
        }
        return response.status;
    },
    async create({ commit }, data) {
        const response = await axios.post(API.API_ADMIN_STORES_CREATE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async checkDeleted({ commit }, data) {
        const response = await axios.get(API.API_ADMIN_STORES_CHECK_DELETED + '/' + data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async checkValidated({ commit }, data) {
        const response = await axios.post(API.API_ADMIN_STORES_CHECK_VALIDATED, data);

        if (response.status === 200) {
            const errors = {
                extend: true,
                errors: {
                    code: null,
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
        const response = await axios.get(API.API_ADMIN_STORES_SHOW + '/' + data);

        if (response.status === 200) {
            if (response.data.status === 200) {
                await commit(SET_STORE, response.data.data.store);
                await commit(SET_EMPLOYEE, response.data.data.employee);
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async update({ commit }, data) {
        const response = await axios.put(API.API_ADMIN_STORES_UPDATE, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async updateLastLoggedIn({ commit }, data) {
        const response = await axios.put(API.API_ADMIN_STORES_UPDATE_LAST_LOGGED_IN, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async cancelResetPassword({ commit }, data) {
        const response = await axios.put(API.API_ADMIN_STORES_CANCEL_RESET_PASSWORD, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async resetPassword({ commit }, data) {
        const response = await axios.put(API.API_ADMIN_STORES_RESET_PASSWORD, data);

        if (response.status === 200) {
            if (response.data.status !== 200) {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return response.data.status;
        }
        return response.status;
    },
    async delete({ commit }, data) {
        const response = await axios.delete(API.API_ADMIN_STORES_DELETE + '/' + data);

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