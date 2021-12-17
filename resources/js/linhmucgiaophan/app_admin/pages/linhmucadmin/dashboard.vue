<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="8" md="6">
      <v-card>
        <v-card-title class="headline">
          Trang Quản Trị
        </v-card-title>
        <v-card-text>
          <a
            href="/"
            target="_blank"
          >
            Trang Chủ
          </a>
          <hr class="my-3">
          <a
            href="/linh-muc"
            target="_blank"
          >
            Danh sách Linh Mục
          </a>
          <hr class="my-3">
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapState } from 'vuex'

export default {
  layout: 'adminPrivate',
  middleware: 'auth',
  data () {
    return {
      linhMuc: {}
    }
  },
  computed: {
    ...mapState('auth', ['user'])
  },
  mounted () {
  }
}
</script>
