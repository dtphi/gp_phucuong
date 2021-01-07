import * as API from '../API';

const SET_PURCHASE = 'SET_PURCHASE'

const state = {
    purchase: null,
};

const getters = {
    purchase: state => state.purchase,
};

const mutations = {
    [SET_PURCHASE](state, payload) {
        state.purchase = payload;
    },
};

const actions = {
    async fetchPurchase({ commit }, data) {
        await commit(SET_PURCHASE, null);
        const response = await axios.get(API.API_STORE_PURCHASE_HISTORY_DETAIL + '/' + data.purchaseId, { params: data });

        if (response.status === 200) {
            if (response.data.status === 200) {
                await commit(SET_PURCHASE, response.data.data.purchase);
            }

            return response.data.status;
        }

        return response.status;
    },

    async reorder({ commit }, data) {
        const response = await axios.post(API.API_STORE_PURCHASE_HISTORY_REORDER, data);

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