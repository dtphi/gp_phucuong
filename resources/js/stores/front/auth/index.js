import {
    fetchLogin,
    fetchSignUp,
    getToken,
    saveToken,
    removeToken
} from "@app/api/front/auths";

export default {
    namespaced: true,
    state: {
        isLoggedIn: !!getToken(),
        authenticated: false,
        user: null,
        redirectUrl: "user/profile",
        redirectLogoutUrl: "user/login",
        redirectRegisterUrl: "user/register",
        redirectLoginUrl: "user/login",
        errors: []
    },
    getters: {
        authenticated(state) {
            return state.authenticated;
        },
        user(state) {
            return state.user;
        },
        errors(state) {
            return state.errors;
        },
        isError(state) {
            return state.errors.length;
      },
      isLogged(state) {
        return state.isLoggedIn;
        }
    },

    mutations: {
        auth_set_authenticated(state, value) {
            state.authenticated = value;
        },
        auth_set_user(state, value) {
            state.user = value;
        },
        auth_set_error(state, value) {
            state.errors = value;
        }
    },
    actions: {
        // login
        async loginUser({ commit }, formData) {
            await fetchLogin(
                response => {
                    console.log(response.access_token, "access_token");
                    saveToken(response.access_token);
                    axios.defaults.headers.common["Authorization"] =
                        response.access_token;
                    commit("auth_set_authenticated", true);
                    commit("auth_set_error", []);
                },
                error => {
                    console.log(error, "error");
                    commit("auth_set_authenticated", false);
                    commit("auth_set_user", null);
                    commit("auth_set_error", [
                        {
                            msgCommon: "Login failed!"
                        }
                    ]);
                },
                formData
            );
        },
        // register
        async registerUser({ commit }, formData) {
            await fetchSignUp(
                response => {
                    console.log(response, "response");
                    commit("auth_set_authenticated", true);
                    commit("auth_set_error", []);
                },
                error => {
                    console.log(error, "error");
                    commit("auth_set_authenticated", false);
                    commit("auth_set_error", [
                        {
                            msgCommon: "Register failed!"
                        }
                    ]);
                },
                formData
            );
        },
        // logout
        logout({ dispatch }) {
            removeToken();
            dispatch("redirectLogoutSuccess");
        },
        redirectLoginSuccess({ state }) {
            window.location = window.location.origin + "/" + state.redirectUrl;
        },
        redirectLogoutSuccess({ state }) {
            window.location =
                window.location.origin + "/" + state.redirectLogoutUrl;
        },
        redirectRegisterUrl({ state }) {
            window.location =
                window.location.origin + "/" + state.redirectRegisterUrl;
        },
        redirectLoginUrl({ state }) {
            window.location =
                window.location.origin + "/" + state.redirectLoginUrl;
        }
    }
};
