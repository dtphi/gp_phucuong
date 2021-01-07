import * as Mutation from '../mutation.types';
import * as API from '../API';

const state = {};

const getters = {};

const mutations = {};

const actions = {
    async getCatalog({ commit }) {
        const response = await axios.get(API.API_STORE_GET_CATALOG_LIST);

        if (response.status === 200) {
            let catalogList = [];

            if (response.data.status === 200) {
                catalogList = response.data.data.catalogList;
            } else {
                await commit(Mutation.SET_ERRORS, response.data.errors, { root: true });
            }
            return {
                status: response.data.status,
                catalogList
            };
        }
        return response.status;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};