<template>
  <!-- Login Card -->
  <form id="login-form" @submit.prevent="_login">
    <p v-if="isError" class="mb-1 text-center text-red">
      {{ errors[0].msgCommon }}
    </p>
    <div class="form-group">
      <label for="input-username">{{ $options.setting.username_txt }}</label>
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input
          type="text"
          ref="email"
          name="username"
          value=""
          :placeholder="$options.setting.username_txt"
          id="input-username"
          class="form-control"
        />
      </div>
    </div>
    <div class="form-group">
      <label for="input-password">{{ $options.setting.password_txt }}</label>
      <div class="input-group">
        <span class="input-group-addon"> <i class="fa fa-lock"></i></span>
        <input
          type="password"
          ref="password"
          name="password"
          :placeholder="$options.setting.password_txt"
          id="input-password"
          class="form-control"
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
          <i class="fa fa-key"></i>{{ $options.setting.btn_submit_txt }}
        </button>
      </div>
    </div>
  </form>
</template>

<script>
import { mapGetters, mapActions, } from 'vuex'
import { MODULE_AUTH, } from 'store@admin/types/module-types'

export default {
  name: 'AuthLogin',
  data() {
    return {
      errorMessage: null,
      form: {
        email: '',
        password: '',
      },
      isSubmit: false,
    }
  },
  computed: {
    ...mapGetters(MODULE_AUTH, ['authenticated', 'isError', 'errors']),
  },
  methods: {
    ...mapActions({
      signIn: 'auth/signIn',
      redirectLogin: 'auth/redirectLoginSuccess',
    }),
    async _submit() {
      await this.signIn(this.form)
      if (this.authenticated) {
        this.redirectLogin()
      } else {
        this.isSubmit = false
      }
    },
    _login() {
      this.isSubmit = true
      const email = this.$refs.email.value
      const password = this.$refs.password.value
      if (email.length !== 0 && password.length !== 0) {
        this.form.email = email
        this.form.password = password
        this._submit()
      }
    },
  },
  setting: {
    username_txt: 'Username',
    password_txt: 'Password',
    btn_submit_txt: 'Login',
  },
}
</script>

<style type="text/css" scoped="">
.text-red {
  color: red;
}
</style>
