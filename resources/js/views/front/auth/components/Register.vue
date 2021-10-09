<template>
    <!-- Login Card -->
    <form id="login-form" @submit.prevent="_register">
        <p v-if="isError" class="mb-1 text-center text-red">
            {{ errors[0].msgCommon }}
        </p>
        <h2>Đăng kí tài khoản</h2>
        <div class="form-group">
            <label for="input-email">{{ $options.setting.email_txt }}</label>
            <div class="input-group">
                <span class="input-group-addon"
                    ><i class="fa fa-user"></i
                ></span>
                <input
                    type="email"
                    ref="email"
                    name="email"
                    value=""
                    :placeholder="$options.setting.email_txt"
                    id="input-email"
                    class="form-control"
                    required
                />
            </div>
        </div>
        <div class="form-group">
            <label for="input-password">{{
                $options.setting.password_txt
            }}</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i
                ></span>
                <input
                    type="password"
                    ref="password"
                    name="password"
                    :placeholder="$options.setting.password_txt"
                    id="input-password"
                    class="form-control"
                    required
                />
            </div>
        </div>
        <div class="text-right">
            <div class="col-4">
                <a
                    v-if="isSubmit"
                    key="btn-submit-spinner"
                    class="btn btn-success btn-block"
                    >{{ $options.setting.btn_submit_txt }}
                    <font-awesome-icon icon="spinner" pulse />
                </a>
                <button
                    v-else
                    key="btn-submit-key"
                    type="submit"
                    class="btn btn-success btn-block"
                >
                    <i class="fa fa-key"></i
                    >{{ $options.setting.btn_submit_txt }}
                </button>
            </div>
        </div>
    </form>
</template>
<script>
import { MODULE_MODULE_AUTH_USER } from "@app/stores/front/types/module-types";
import { mapActions, mapMutations, mapState, mapGetters } from "vuex";
export default {
    data() {
        return {
            errorMessage: null,
            formData: {
                email: "",
                password: ""
            },
            isSubmit: false
        };
    },
    beforeMount() {
      if(this.isLogged == true) {
        this.$router.push({ name: 'profile'})
      }
    },
    computed: {
        ...mapGetters("authUser", {
            authenticated: "authenticated",
            isError: "isError",
            errors: "errors"
        })
    },
    methods: {
        ...mapActions("authUser", {
            registerUser: "registerUser",
            redirectLoginUrl: "redirectLoginUrl"
        }),
        async _submit() {
            await this.registerUser(this.formData); // sent action => store(front/auth/index)
            if (this.authenticated) {
                alert("Đăng kí tài khoản thành công, vui lòng đăng nhập lại.");
                this.redirectLoginUrl();
            } else {
                this.isSubmit = false;
            }
        },
        _register() {
            this.isSubmit = true;
            const email = this.$refs.email.value;
            const password = this.$refs.password.value;
            if (email.length !== 0 && password.length !== 0) {
                this.formData.email = email;
                this.formData.password = password;
                this._submit();
            }
        }
    },
    setting: {
        email_txt: "Email",
        password_txt: "Password",
        btn_submit_txt: "Register"
    }
};
</script>
<style></style>
