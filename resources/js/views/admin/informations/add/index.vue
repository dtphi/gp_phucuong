<template>
  <div id="content">
    <template v-if="_errors">
      <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i>
        <button type="button" class="close" data-dismiss="alert">
          &times;
        </button>
        <p v-for="(err, idx) in _errorToArrs()" :key="idx">{{ err }}</p>
      </div>
    </template>
    <template v-if="loading">
      <loading-over-lay
        :active.sync="loading"
        :is-full-page="fullPage"
      ></loading-over-lay>
    </template>
    <validation-observer ref="observerInfo" @submit.prevent="_submitInfo">
      <div class="page-header">
        <div class="container-fluid">
          <div class="pull-right">
            <button
              type="button"
              @click="_submitInfo"
              data-toggle="tooltip"
              :title="$options.setting.btn_save_txt"
              class="btn btn-primary"
            >
              <i class="fa fa-save"></i>
            </button>
            <button
              type="button"
              @click="_submitInfoBack"
              data-toggle="tooltip"
              title="Lưu"
              class="btn btn-primary"
            >
              {{ $options.setting.btn_save_back_txt }}
            </button>
            <the-btn-back-list-page></the-btn-back-list-page>
          </div>
          <h1>{{ $options.setting.panel_title }}</h1>
          <breadcrumb></breadcrumb>
        </div>
      </div>
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <i class="fa fa-pencil"></i>{{ $options.setting.frm_title }}
            </h3>
          </div>
          <div class="panel-body">
            <info-add-form ref="formAddUser"></info-add-form>
          </div>
        </div>
      </div>
    </validation-observer>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters, } from 'vuex'

import InfoAddForm from 'com@admin/Form/Infos/AddForm'
import Breadcrumb from 'com@admin/Breadcrumb'
import TheBtnBackListPage from '../components/TheBtnBackListPage'
import {
  MODULE_INFO_ADD,
  MODULE_MODULE_SPECIAL_INFO_CAROUSEL,
} from 'store@admin/types/module-types'
import { ACTION_RESET_NOTIFICATION_INFO, } from 'store@admin/types/action-types'

export default {
  name: 'InformationAdd',
  components: {
    Breadcrumb,
    InfoAddForm,
    TheBtnBackListPage,
  },
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapGetters(MODULE_MODULE_SPECIAL_INFO_CAROUSEL, ['specialInfoCarousel']),
    ...mapState(MODULE_INFO_ADD, {
      loading: (state) => state.loading,
      errors: (state) => state.errors,
      insertSuccess: (state) => state.insertSuccess,
    }),
    _errors() {
      return this.errors.length
    },
  },
  watch: {
    insertSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_INFO_ADD, {
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
      update_special_carousel: 'update_special_carousel',
    }),
    _errorToArrs() {
      let errs = []
      if (
        this.errors.length &&
        typeof this.errors[0].messages !== 'undefined'
      ) {
        errs = Object.values(this.errors[0].messages)
      }

      if (Object.entries(errs).length === 0 && this.errors.length) {
        errs.push(this.$options.setting.error_msg_system)
      }

      return errs
    },
    _submitInfo() {
      this.update_special_carousel(this.specialInfoCarousel)
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formAddUser._submitInfo()
        }
      })
    },
    _submitInfoBack() {
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formAddUser._submitInfoBack()
        }
      })
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification('')
    },
  },
  setting: {
    panel_title: 'Tin Tức',
    frm_title: 'Thêm tin',
    btn_save_txt: 'Lưu',
    btn_save_back_txt: 'Lưu trở về danh sách',
  },
}
</script>
