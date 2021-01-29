<template>
    <!-- Login Card -->
    <div class="card">
      
      <!-- Card Header -->
      <div class="card-header login-card-header">
        <!-- Login Logo -->
        <div class="login-logo">
          <a href="#!" alt="admin@gmail.com/password" title="Admin">
            <img src="/administrator/img/logo.png" alt="logo">
          </a>
        </div>
        <!-- End Login Logo -->
      </div>
      <!-- End Card Header -->

      <!-- Card Body -->
      <div class="card-body login-card-body">
        <!-- <p class="login-box-msg">Login</p> -->
        <p v-if="isError" class="mb-1 text-center text-red">{{errors[0].msgCommon}}</p>

        <form @submit.prevent="login">
          <div class="input-group mb-4">
            <input ref="email" required type="email" class="form-control" placeholder="User">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-5">
            <input ref="password" required type="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-success btn-block">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <p class="mb-1 text-center">
          <a class="login-link" href="#!" title="Link to Reset Pasword">I forgot my password</a>
        </p> -->
      </div>
      <!-- Card Body -->


    </div>
    <!-- Login Card -->
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'Login',
        data() {
            return {
                errorMessage: null,
                form : {
                    email: '',
                    password: '',
                }
            };
        },
        computed: {
            ...mapGetters('auth', ['authenticated', 'isError', 'errors']),
        },
        methods: {
            ...mapActions({
                signIn: 'auth/signIn',
                redirectLogin: 'auth/redirectLoginSuccess'
              }),
            async submit () {
                await this.signIn(this.form);

                if (this.authenticated) {
                  this.redirectLogin();
                }
            },
            login() {
                const email = this.$refs.email.value;
                const password = this.$refs.password.value;

                if (email.length !== 0 && password.length !== 0) {
                    this.form.email = email;
                    this.form.password = password;
                    this.submit();
                }
            }
        }
    };
</script>