<template>
    <validation-observer ref="observerNewEmail" @submit.prevent="_submitInfo">
        <div id="news-letter-register-component">
            <h4 class="tit-common clr-blue">Quan tâm</h4>

            <p class="font-weight-bold">Đăng ký để nhận tin mỗi ngày</p>
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
            <input class="btn mt-2" type="button" value="Subscribe" @click="_submitInfo">

            <hr class="border my-4">
        </div>
    </validation-observer>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import { MODULE_SUBSCRIBE } from "store@front/types/module-types";
import { setInteractionMode } from 'vee-validate'
setInteractionMode('passive')

export default {
  name: "RegistryNewsletter",
  components: {},
  data() {
    return {
      text_notification: '',
      fullPage: false,
    };
  },
  // loading vs errors trong stata
  computed: {
    ...mapState(MODULE_SUBSCRIBE, {
      loading: (state) => state.loading,
      errors: (state) => state.errors,
    }),
    ...mapGetters(MODULE_SUBSCRIBE, ["subscribe", "loading", 'insertSuccess']),
    _errors() {
      return this.errors.length;
    },
  },
  watch: {
    'insertSuccess'(newValue) {
      if (typeof newValue == "boolean") {
        if(newValue){
          this.$refs.observerNewEmail.reset();
          this._notificationUpdate('Đã đăng ký nhận tin thành công!', 'success');
        } else {
          this._notificationUpdate('Email nhận tin chưa hợp lệ!', 'error');
        }
      }
    },
  },
  methods: {
    ...mapActions(MODULE_SUBSCRIBE, [
      "ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER",
      "RESET_NOTIFICATION"
    ]),
    _errorToArrs() {
      const errs = [];
      if (
        this.errors.length &&
        typeof this.errors[0].messages !== "undefined"
      ) {
        errs.push("Email đã được đăng kí!");
      }
      if (Object.entries(errs).length === 0 && this.errors.length) {
        errs.push(this.$options.setting.error_msg_system);
      }
      return errs;
    },
    async _submitInfo() {
      const _self = this;
      await _self.$refs.observerNewEmail.validate().then((isValid) => {
        if (isValid) {
          _self.ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER(_self.subscribe);
        } else {
          _self._notificationUpdate('Email nhận tin chưa hợp lệ!', 'error');
        }
      });
    },
    _notificationUpdate(msg, type) {
      this.$notify({
        group: this.$options.setting.groupNotify,
        type: type,
        title: msg,
        text: this.text_notification,
      });
      this.RESET_NOTIFICATION(null);
    }
  },
  setting: {
    error_msg_system: "Lỗi hệ thống !",
    groupNotify: 'add_email'
  },
};
</script>
