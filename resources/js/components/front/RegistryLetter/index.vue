<template>
  <div>
    <!--  Loading page -->
    <template v-if="loading">
      <loading-over-lay :active.sync="loading" :is-full-page="fullPage">
      </loading-over-lay>
    </template>
    <template v-if="subscribe">
      <validation-observer ref="observerNewEmail" @submit.prevent="_submitInfo">
        <h4 class="tit-ft mb-3">Quan tâm</h4>
        <p class="font-weight-bold">Đăng ký để nhận tin mỗi ngày</p>
        <div class="form">
          <!-- Kiem tra input -->
          <validation-provider
            name="email"
            rules="required|email|max:191"
            v-slot="{}"
          >
            <input
              class="d-block mb-3 form-input"
              type="text"
              name="email"
              id="input-subscribe-email"
              placeholder="Enter your e-mail address"
              v-model="subscribe.email"
            />
          </validation-provider>
          <!-- Submit from -->
          <button class="btn" type="button" @click="_submitInfo">
            Subscribe
          </button>
        </div>
      </validation-observer>
    </template>
    <notifications group="add_email"></notifications>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import Vue from 'vue'
import Notifications from 'vue-notification'
Vue.use(Notifications)
import { ValidationObserver, ValidationProvider, } from 'vee-validate'
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)
import { MODULE_SUBSCRIBE, } from 'store@front/types/module-types'
import { setInteractionMode, } from 'vee-validate'
setInteractionMode('passive')

export default {
  name: 'RegistryLetter',
  data() {
    return {
      text_notification: '',
      fullPage: false,
    }
  },
  // loading vs errors trong stata
  computed: {
    ...mapState(MODULE_SUBSCRIBE, {
      loading: (state) => state.loading,
      errors: (state) => state.errors,
    }),
    ...mapGetters(MODULE_SUBSCRIBE, ['subscribe', 'loading', 'insertSuccess']),
    _errors() {
      return this.errors.length
    },
  },
  watch: {
    insertSuccess(newValue) {
      if (typeof newValue == 'boolean') {
        if (newValue) {
          this.$refs.observerNewEmail.reset()
          this._notificationUpdate('Đã đăng ký nhận tin thành công!', 'success')
        } else {
          this._notificationUpdate('Email nhận tin chưa hợp lệ!', 'error')
        }
      }
    },
  },
  methods: {
    ...mapActions(MODULE_SUBSCRIBE, [
      'ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER',
      'RESET_NOTIFICATION'
    ]),
    _errorToArrs() {
      const errs = []
      if (
        this.errors.length &&
        typeof this.errors[0].messages !== 'undefined'
      ) {
        errs.push('Email đã được đăng kí!')
      }
      if (Object.entries(errs).length === 0 && this.errors.length) {
        errs.push(this.$options.setting.error_msg_system)
      }

      return errs
    },
    async _submitInfo() {
      const _self = this
      await _self.$refs.observerNewEmail.validate().then((isValid) => {
        if (isValid) {
          _self.ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER(_self.subscribe)
        } else {
          _self._notificationUpdate('Email nhận tin chưa hợp lệ!', 'error')
        }
      })
    },
    _notificationUpdate(msg, type) {
      this.$notify({
        group: this.$options.setting.groupNotify,
        type: type,
        title: msg,
        text: this.text_notification,
      })
      this.RESET_NOTIFICATION(null)
    },
  },
  setting: {
    error_msg_system: 'Lỗi hệ thống !',
    groupNotify: 'add_email',
  },
}
</script>
<style>
.form-input {
  width: 100%;
  border-radius: 4px;
  outline: 0;
  background-color: #cccccc;
  padding: 5px;
}
</style>
