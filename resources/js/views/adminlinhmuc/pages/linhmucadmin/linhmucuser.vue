<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="12" md="11">
      <v-card>
        <v-card-title class="headline justify-center">
          Tạo tài khoản linh mục quản trị
        </v-card-title>
        <div class="pa-3">
          <v-text-field
            ref="input_user_email"
            v-model="user_email"
            autocomplete="new-email"
            label="Nhập địa chỉ email"
            :rules="emailRules"
          />
          <v-text-field
            v-model="user_password"
            autocomplete="new-password"
            type="password"
            label="Nhập mật khẩu"
          />
          <v-text-field
            v-model="user_name"
            autocomplete="off"
            label="Nhập tên linh mục tìm kiếm"
          />
          <div class="text-right">
            <v-btn color="teal" outlined @click="_searchByUserName">
              Tìm kiếm
            </v-btn>
            <v-btn color="teal" outlined @click="_getLinhMucAll">
              Tìm tất cả
            </v-btn>
          </div>
          <hr class="my-3">
          <v-card-title class="headline">
            <v-icon>mdi-account-box</v-icon>
            {{ user_select }}
          </v-card-title>
        </div>
        <v-card-actions v-if="isSubmit">
          <v-spacer />
          <v-btn color="teal" outlined @click="_addAcountLinhMuc">
            Thêm
          </v-btn>
        </v-card-actions>
      </v-card>
      <v-card
        elevation="16"
        class="mx-auto"
      >
        <v-virtual-scroll
          :bench="benched"
          :items="items"
          height="250"
          item-height="54"
        >
          <template #default="{ item }">
            <v-list-item :key="item.id">
              <v-list-item-action>
                <v-btn
                  fab
                  small
                  depressed
                  color="primary"
                  @click="_selectUser(item)"
                >
                  <v-icon small>
                    mdi-check-outline
                  </v-icon>
                </v-btn>
              </v-list-item-action>

              <v-list-item-content>
                <v-list-item-title>
                  <strong>{{ item.ten }}</strong>
                </v-list-item-title>
              </v-list-item-content>

              <v-list-item-action
                @click="_redirectDetail(item)"
              >
                <v-icon small>
                  mdi-open-in-new
                </v-icon>
              </v-list-item-action>
            </v-list-item>

            <v-divider />
          </template>
        </v-virtual-scroll>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios'
import { getAuth, createUserWithEmailAndPassword } from 'firebase/auth'
const firebaseAuth = getAuth()

export default {
  layout: 'adminPrivate',
  middleware: 'auth',
  data () {
    return {
      user_email: '',
      user_password: '',
      user_name: '',
      user_id: '',
      user_select: '',
      benched: 0,
      isSubmit: false,
      linhmucs: [],
      errors: {
        email: true,
        uId: true
      },
      emailRules: []
    }
  },
  computed: {
    items () {
      if (this.linhmucs.length) {
        const newUsers = this.linhmucs.map((user) => {
          const item = {
            ...user,
            href: `/linh-muc/chi-tiet/${user.id}`
          }
          return item
        })
        return newUsers
      }
      return []
    }
  },
  watch: {
    user_email (valnewEmail) {
      if (valnewEmail !== '') {
        this.emailRules = [(v) => {
          const check = v.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
          return (check ? true : check) || 'Email chưa đúng'
        }]
      } else if (valnewEmail === '') {
        this.emailRules = []
      }
      if (valnewEmail.length > 3) {
        if (!this.$refs.input_user_email.valid) {
          this.errors.email = true
        } else {
          this.errors.email = false
        }
        this._checkSubmit()
      }
    },
    user_id (valnewId) {
      if (valnewId && (parseInt(valnewId) > 0)) {
        this.errors.uId = false
      } else {
        this.errors.uId = true
      }
      this._checkSubmit()
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
    _selectUser (userSelect) {
      this.user_select = userSelect.ten
      this.user_id = userSelect.id
      if (userSelect.email) {
        this.user_email = userSelect.email
      }
    },
    _redirectDetail (userSelect) {
      window.open(`${userSelect.href}`)
    },
    _checkSubmit () {
      const test = ((this.errors.email === false) && (this.errors.uId === false))
      if (test) {
        this.isSubmit = true
      }
    },
    _searchByUserName () {
      if (this.user_name.length) {
        axios.get(this._getApiBaseUrl(), {
          params: {
            action: 'linh.muc.list.filter',
            app: this._getApiApp(),
            firebasephone: this._getApiFirebase(),
            name: this.user_name
          }
        }).then((response) => {
          this.linhmucs = response.data
        })
      }
    },
    _getLinhMucAll () {
      axios.get(this._getApiBaseUrl(), {
        params: {
          action: 'linh.muc.list',
          app: this._getApiApp(),
          firebasephone: this._getApiFirebase()
        }
      }).then((response) => {
        this.linhmucs = response.data
      })
    },
    _updateLinhMuc (uId) {
      const linhMucId = this.user_id
      const linhMucEmail = this.user_email
      const linhMucPass = this.user_password
      axios.post(this._getApiBaseUrl(), {
        params: {
          action: 'linh.muc.update.uid',
          app: this._getApiApp(),
          firebasephone: this._getApiFirebase(),
          uid: uId,
          id: linhMucId,
          email: linhMucEmail,
          passw: linhMucPass
        }
      }).then((response) => {
        if (Object.keys(response.data).length) {
          alert('Thêm thành công')
        } else {
          alert('Thêm thất bại')
        }
        this._resetData()
      })
    },
    async _addAcountLinhMuc () {
      this._checkSubmit()
      if (this.isSubmit) {
        const userCredential = await createUserWithEmailAndPassword(firebaseAuth, this.user_email, this.user_password)
        this.isSubmit = false
        const { uid } = userCredential.user
        if (uid) {
          this._updateLinhMuc(uid)
        }
      }
    },
    _resetData () {
      this.user_password = ''
      this.user_name = ''
      this.user_id = ''
      this.user_select = ''
      this.user_email = ''
    }
  }
}
</script>
