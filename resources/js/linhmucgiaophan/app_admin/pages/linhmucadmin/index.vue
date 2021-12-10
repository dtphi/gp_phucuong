<template>
  <v-row justify="center">
    <v-col cols="12" sm="5" md="4">
      <v-card>
        <v-img
          src="/icon.png"
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
          <v-btn color="teal" outlined @click="signInUser">
            Đăng nhập
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex'
import { getAuth, onAuthStateChanged, signInWithEmailAndPassword } from 'firebase/auth'
const auth = getAuth()

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
  created () {
    onAuthStateChanged(auth, (user) => {
      if (user) {
        this.$router.push('/linhmucadmin/dashboard')
      }
    })
  },
  methods: {
    ...mapActions('auth', ['setUser']),
    async signInUser () {
      try {
        await signInWithEmailAndPassword(auth, this.formData.email, this.formData.password)
          .then((userCredential) => {
            this.setUser(userCredential.user)
          })
          .catch((error) => {
            this.errors = error
          })
        if (this.user) {
          this.$router.push('/linhmucadmin/dashboard')
        }
      } catch (e) {
        alert(e)
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
