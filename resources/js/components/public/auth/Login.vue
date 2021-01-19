<template>
    <!-- Login Card -->
    <div class="card">
      
      <!-- Card Header -->
      <div class="card-header login-card-header">
        <!-- Login Logo -->
        <div class="login-logo">
          <a href="#!" title="Admin">
            <img src="img/logo.png" alt="logo">
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
                    password: null,
                    tipData: { title: 'ログインＩＤとは<br>販売店様は99からはじまる8桁の数字、日東の営業担当者はメインメールアドレスを入力してください。' }
                },
                systemError: null,
                height: '0px'
            };
        },
        created() {
            this.systemError = this.getSystemErrors();
            this.clearSystemErrors();
        },
        mounted() {
            this.height = this.styleHeight(true);
        },
        methods: {
            ...mapActions('representative.auth', { representativeLogin: 'login' }),
            ...mapActions('store.auth', { storeLogin: 'login' }),
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
            validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{1,}))$/;
                return re.test(String(email).toLowerCase());
            },
            async onSubmit() {
                if (this.validateEmail(this.form.email)) {
                    const status = await this.representativeLogin(this.form);

                    if (status === 200) {
                        this.$router.push({ name: 'representative.menu.main.menu' });
                    }
                } else {
                    const status = await this.storeLogin(this.form);

                    if (status === 200) {
                        this.$router.push({ name: 'store.menu.main.menu' });
                    }
                }
            },
            test() {
                const wh = $(window).height();
                const footer = $('footer').outerHeight();

                return `${wh - footer}px`;
            }
        }
    };
</script>

<style scoped>

</style>