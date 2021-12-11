<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="8" md="6">
      <v-card>
        <v-card-title class="headline">
          Welcome to Linh Mục
        </v-card-title>
        <a
          :href="_getHrefUserDetail"
          target="_blank"
        >
          Thông tin Linh Mục
        </a>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapState } from 'vuex'
import axios from 'axios'

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
        return '/linh-muc/chi-tiet/' + this.linhMuc.id
      } else {
        return 'javascript:void(0);'
      }
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
    _getByUId (uId) {
      if (uId) {
        axios.get(this._getApiBaseUrl(), {
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
