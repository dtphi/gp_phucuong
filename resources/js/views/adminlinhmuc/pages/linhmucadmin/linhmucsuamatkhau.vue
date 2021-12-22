<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="12" md="11">
      <v-card>
        <v-card-title class="headline text-center">
          Thay đổi mật khẩu
        </v-card-title>
        <v-text-field
          v-model="user_password"
          autocomplete="new-password"
          type="password"
          label="Nhập mật khẩu"
        />
      </v-card>
    </v-col>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
      <template #activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Cập nhật mật khẩu
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Xác nhận đăng nhập</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="login_email"
                  label="Nhập email*"
                  required
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="login_password"
                  label="Nhập mật khẩu*"
                  type="password"
                  required
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Thoát
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="_confirmAuthen()"
          >
            Xác nhận thay đổi
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
/* https://firebase.google.com/docs/reference/js/auth.emailauthprovider?hl=en */
import { mapState } from 'vuex'
import {
  getAuth,
  signOut,
  reauthenticateWithCredential,
  updatePassword,
  EmailAuthProvider
} from 'firebase/auth'
const firebaseAuth = getAuth()

export default {
  name: 'SuaMatKhau',
  layout: 'adminPrivate',
  middleware: 'auth',
  data () {
    return {
      linhMuc: {},
      user_password: '',
      login_email: '',
      login_password: '',
      dialog: false,
      credential: null,
      errors: null
    }
  },
  computed: {
    ...mapState('auth', ['user']),
    linhMucUser () {
      return firebaseAuth.currentUser
    }
  },
  methods: {
    _getApiBaseUrl () {
      return process.env.apiBaseUrl + '/linh-muc'
    },
    _getApiApp () {
      return process.env.appMiddle
    },
    _getApiFirebase () {
      return process.env.firebasephoneMiddle
    },
    _promptForCredentials () {
      if (this.user_password) {
        this.dialog = true
      }
    },
    async _confirmAuthen () {
      this.credential = await EmailAuthProvider.credential(this.login_email, this.login_password)
      if (this.credential) {
        this._reauthenticate()
      }
    },
    _reauthenticate () {
      const newPassword = this.user_password
      const user = firebaseAuth.currentUser
      reauthenticateWithCredential(user, this.credential).then(() => {
        this.dialog = false
        updatePassword(user, newPassword).then(() => {
          localStorage.removeItem('authen-lm')
          signOut(firebaseAuth)
          alert('Cập nhật mật khẩu thành công')
        })
      }).catch((error) => {
        this.errors = error
      })
    }
  }
}
</script>
