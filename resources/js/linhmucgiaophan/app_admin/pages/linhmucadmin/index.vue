<template>
  <v-row justify="center">
    <v-col cols="12" sm="5" md="4">
      <v-card>
        <v-img
          src="/administrator/linhmucadmin-images/logo.png"
        />
        <v-card-title class="font-weight-bold title">
          Đăng nhập quản trị
        </v-card-title>
        <div class="pa-3">
          <v-text-field
            v-model="formData.email"
            label="Nhập địa chỉ email"
          />
          <v-text-field
            v-model="formData.password"
            type="password"
            label="Nhập mật khẩu"
          />
        </div>
        <v-card-actions>
          <v-spacer />
          <v-btn color="teal" outlined @click="_signInUser">
            Đăng nhập
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex'
import { getAuth, signInWithEmailAndPassword } from 'firebase/auth'
const firebaseAuth = getAuth()

export default {
  data () {
    return {
      formData: {
        email: '',
        password: ''
      },
      errors: {}
    }
  },
  computed: {
    ...mapState('auth', ['user']),
    ...mapGetters('auth', ['isAuthenticated'])
  },
  mounted () {
    this._checkQuery()
  },
  methods: {
    ...mapActions('auth', ['setUser']),
    async _signInUser () {
      this._checkQuery()
      try {
        const userCredential = await signInWithEmailAndPassword(firebaseAuth, this.formData.email, this.formData.password)
          .catch((error) => {
            this.errors = error
          })
        const { uid, email, displayName } = userCredential.user
        this._redirectDashBoard({ uid, email, displayName })
      } catch (e) {
        alert(e)
      }
    },
    async _redirectDashBoard (loginAcount) {
      const account = { ...loginAcount }
      await this.setUser(account)
      window.location.href = '/linh-muc/chi-tiet/' + this.$route.query.linhmucId
    },
    _checkQuery () {
      if (this.$route.query) {
        const values = Object.keys(this.$route.query)
        if (!values.includes('linhmucId')) {
          window.location.href = '/linh-muc'
          return 0
        }
        if (!this.$route.query.linhmucId) {
          window.location.href = '/linh-muc'
          return 0
        }
      }
    }
  }
}
</script>

/*{
  "error": {
    "code": 400,
    "message": "PASSWORD_LOGIN_DISABLED",
    "errors": [
      {
        "message": "PASSWORD_LOGIN_DISABLED",
        "domain": "global",
        "reason": "invalid"
      }
    ]
  }
}*/
/*{
  "error": {
    "code": 400,
    "message": "INVALID_PASSWORD",
    "errors": [
      {
        "message": "INVALID_PASSWORD",
        "domain": "global",
        "reason": "invalid"
      }
    ]
  }
}*/
