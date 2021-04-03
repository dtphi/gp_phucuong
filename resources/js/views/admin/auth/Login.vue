<template>
    <!-- Login Card -->
    <form id="login-form" @submit.prevent="_login">
        <p v-if="isError" class="mb-1 text-center text-red">{{errors[0].msgCommon}}</p>
        <div class="form-group">
            <label for="input-username">Username</label>
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="text" ref="email" name="username" value="" placeholder="Username" id="input-username" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="input-password">Password</label>
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" ref="password" name="password" placeholder="Password" id="input-password" class="form-control">
            </div>
            </div>
          <div class="text-right">

            <div class="col-4">
                <a v-if="isSubmit" class="btn btn-success btn-block">Login
                    <font-awesome-icon icon="spinner" pulse/>
                </a>
                <button v-else type="submit" class="btn btn-success btn-block"><i class="fa fa-key"></i>Login</button>
            </div>
          </div>
    </form>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_AUTH
    } from 'store@admin/types/module-types';

    export default {
        name: 'Login',
        data() {
            return {
                errorMessage: null,
                form: {
                    email: '',
                    password: '',
                },
                isSubmit: false
            };
        },
        computed: {
            ...mapGetters(MODULE_AUTH, ['authenticated', 'isError', 'errors']),
        },
        methods: {
            ...mapActions({
                signIn: 'auth/signIn',
                redirectLogin: 'auth/redirectLoginSuccess'
            }),
            async _submit() {
                await this.signIn(this.form);

                if (this.authenticated) {
                    this.redirectLogin();
                } else {
                    this.isSubmit = false;
                }
            },
            _login() {
                this.isSubmit = true;
                const email = this.$refs.email.value;
                const password = this.$refs.password.value;

                if (email.length !== 0 && password.length !== 0) {
                    this.form.email = email;
                    this.form.password = password;
                    this._submit();
                }
            }
        }
    };
</script>

<style type="text/css" scoped="">
    .text-red { color: red }
</style>
