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
            <info-edit-form ref="formLinhMuc"></info-edit-form>
          </div>
        </div>
      </div>
    </validation-observer>
  </div>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import InfoEditForm from 'com@admin/Form/LinhMucs/EditForm'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import linhMucMix from '@app/mixins/admin/linhmuc'
import {
  fn_redirect_url,
} from '@app/api/utils/fn-helper'

export default {
  name: 'LinhMucEdit',
  mixins: [linhMucMix.form],
  beforeCreate() {
    const linhmucId = parseInt(this.$route.params.linhmucId)
    if (!linhmucId) {
      return fn_redirect_url('admin/linh-mucs')
    }
  },
  components: {
    InfoEditForm,
  },
  data() {
    return {}
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
      loading: state => state.loading,
      errors: state => state.errors,
      insertSuccess: state => state.insertSuccess,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, {
      getInfo: ACTION_GET_INFO_BY_ID,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
  },
  mounted() {
    const linhmucId = parseInt(this.$route.params.linhmucId)
    if (linhmucId) {
      this.getInfo(linhmucId)
    }
  },
  setting: {
    panel_title: 'Linh Mục',
    btn_save_txt: 'Lưu',
    btn_save_back_txt: 'Lưu trở về danh sách',
    frm_title: 'Sửa Linh Mục',
  },
}
</script>
