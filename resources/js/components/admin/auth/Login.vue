<template>
    <!-- Login Card -->
    <div class="card">
      
      <!-- Card Header -->
      <div class="card-header login-card-header">
        <!-- Login Logo -->
        <div class="login-logo">
          <a href="#!" title="Admin">
            <img src="/img/logo.png" alt="logo">
          </a>
        </div>
        <!-- End Login Logo -->
      </div>
      <!-- End Card Header -->

      <!-- Card Body -->
      <div class="card-body login-card-body">
        <!-- <p class="login-box-msg">Login</p> -->

        <form action="#!" method="post">
          <div class="input-group mb-4">
            <input type="text" class="form-control" placeholder="User">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-5">
            <input type="password" class="form-control" placeholder="Password">
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

        <p class="mb-1 text-center">
          <a class="login-link" href="#!" title="Link to Reset Pasword">I forgot my password</a>
        </p>
      </div>
      <!-- Card Body -->


    </div>
    <!-- Login Card -->
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'Login',
        data() {
            return {
                form: {
                    email: null,
                    password: null
                },
                systemError: null
            };
        },
        created() {
            this.systemError = this.getSystemErrors();
            this.clearSystemErrors();
        },
        methods: {
            ...mapActions('admin.auth', [ 'login' ]),
            getValidationState({ dirty, validated, valid = null }) {
                return dirty || validated ? valid : null;
            },
            onEmailChange() {
                if (this.errorMessages && this.errorMessages.email) {
                    this.errorMessages.email = null;
                }
            },
            onPasswordChange() {
                if (this.errorMessages && this.errorMessages.password) {
                    this.errorMessages.password = null;
                }
            },
            async onSubmit() {
                const status = await this.login(this.form);

                if (status === 200) {
                    this.$router.push({ name: 'admin.menu.main.menu' });
                }
            }
        }
    };
</script>

<style scoped>

</style>