<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="12" md="11">
      <v-card>
        <v-card-title class="headline">
          Welcome to Linh Mục
        </v-card-title>
        <div>
          <a v-if="_getHrefUserDetail" :href="`/linh-muc/chi-tiet/${linhMuc.id}`" target="_blank">Thông tin chi tiết</a>
          <span v-else>{{ (user) ? user.email : 'Tài khoản chưa có trong dữ liệu' }}</span>
        </div>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapState } from 'vuex'
import axios from 'axios'
import { getAuth } from 'firebase/auth'
const firebaseAuth = getAuth()
const linhMucUser = firebaseAuth.currentUser

export default {
  layout: 'adminPrivate',
  middleware: 'auth',
  data () {
    return {
      linhMuc: {}
    }
  },
  computed: {
    ...mapState('auth', ['user']),
    _getHrefUserDetail () {
      if (Object.keys(this.linhMuc).length) {
        return true
      }

      return false
    }
  },
  mounted () {
    if (this.user) {
      this._getByUId(this.user.uid)
    } else {
      this.$router.push('/linhmucadmin/dashboard')
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
    async _getByUId (uId) {
      uId = (linhMucUser) ? linhMucUser.uid : uId
      if (uId) {
        await axios.get(this._getApiBaseUrl(), {
          params: {
            action: 'linh.muc.list.filter',
            app: this._getApiApp(),
            firebasephone: this._getApiFirebase(),
            uid: uId
          }
        }).then((response) => {
          this.linhMuc = response.data
        })
      }
    }
  }
}
</script>
