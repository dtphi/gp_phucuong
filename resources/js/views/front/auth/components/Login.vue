<template>
    <!-- Login Card -->
    <form id="login-form" @submit.prevent="_login">
        <p v-if="isError" class="mb-1 text-center text-red">
            {{ errors[0].msgCommon }}
        </p>
        <h2>Đăng nhập tài khoản</h2>
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
import { mapActions, mapMutations, mapState, mapGetters } from "vuex";
export default {
    name: "UserLogin",
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
    computed: {
        ...mapGetters("authUser", {
            authenticated: "authenticated",
            isError: "isError",
            errors: "errors",
            isLogged: "isLogged"
        })
    },
    beforeMount() {
      if(this.isLogged == true) {
        this.$router.push({ name: 'profile'})
      }
    },
    methods: {
        ...mapActions("authUser", {
            loginUser: "loginUser",
            redirectLoginSuccess: "redirectLoginSuccess"
        }),
        async _submit() {
            await this.loginUser(this.formData); // sent action => store(front/auth/index)
            if (this.authenticated) {
                console.log("chuyen huong");
                this.redirectLoginSuccess();
            } else {
                this.isSubmit = false;
            }
        },
        _login() {
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
        btn_submit_txt: "Login"
    }
};
</script>
<style></style>
