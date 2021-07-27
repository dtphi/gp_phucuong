<template>
  <div>
    <!-- Show errors -->
    <template v-if="_errors">
      <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i>
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
        <p v-for="(err, idx) in _errorToArrs()" :key="idx">{{ err }}</p>
      </div>
    </template>
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
            v-slot="{ errors }"
          >
            <input
              class="d-block mb-3 form-input"
              type="text"
              name="email"
              id="input-subscribe-email"
              placeholder="Enter your e-mail address"
              v-model="subscribe.email"
            />
            <span class="cms-text-red">{{ errors[0] }}</span>
          </validation-provider>
          <!-- Submit from -->
          <button class="btn" type="button" @click="_submitInfo">
            Subscribe
          </button>
        </div>
      </validation-observer>
    </template>
    <notifications group="add_email" />
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import { MODULE_SUBSCRIBE } from "store@front/types/module-types";
import { fn_get_tinymce_langs_url } from "@app/api/utils/fn-helper";
import { setInteractionMode } from 'vee-validate'
setInteractionMode('passive')

export default {
  name: "RegistryLetter",
  components: {},
  data() {
    return {
      text_notification: '',
      fullPage: false,
      options: {
        language_url: fn_get_tinymce_langs_url("vi_VN"),
      },
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
      console.log(newValue);
      if(newValue){
        this.$refs.observerNewEmail.reset();
        this._notificationUpdate();
      }
    },
  },
  methods: {
    ...mapActions(MODULE_SUBSCRIBE, [
      "ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER",
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
          this.text_notification = _self.subscribe.email;
        }
      });
    },
    _notificationUpdate() {
      this.$notify({
        group: 'add_email',
        type: 'success',
        title: 'Insert successfully!',
        text: this.text_notification,
      })
    }
  },
  setting: {
    error_msg_system: "Lỗi hệ thống !",
  },
};
</script>
<style>
.cms-text-red {
  display: block;
  color: red;
}
.form-input {
  width: 100%;
  border-radius: 4px;
  outline:0;
  background-color: #CCCCCC;
  padding: 5px;
}
</style>


