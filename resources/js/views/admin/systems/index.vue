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
    <template>
      <div class="page-header">
        <div class="container-fluid">
          <h1>Cài đặt</h1>
          <breadcrumb></breadcrumb>
        </div>
      </div>
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Thay đổi</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal">
              <ul class="nav nav-tabs">
                <li class="active">
                  <a href="#tab-general" data-toggle="tab">Tổng quan</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
                  <validation-observer
                    ref="observerLogo"
                    @submit.prevent="_submitInfo"
                  >
                    <div class="form-group required">
                      <label class="col-sm-1 control-label">Logo</label>
                      <div class="col-sm-1">
                        <span class="btn btn-default" @click="_selectLogoImage">
                          <i class="fa fa-image fa-fw" />
                        </span>
                      </div>
                      <div class="col-sm-2">
                        <div class="file animated fadeIn" style="height: 61px">
                          <div class="file-preview">
                            <img :src="_getImageAvatar('logo')" class="thumb" />
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-8">
                        <div class="pull-right">
                          <button
                            type="button"
                            @click="_submitLogoInfo"
                            data-toggle="tooltip"
                            title="Cập nhật"
                            class="btn btn-primary"
                          >
                            <i class="fa fa-save"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1 control-label">Logo Tiêu đề</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          v-model="system.logo_title"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1 control-label"
                        >Logo Tiêu đề 1</label
                      >
                      <div class="col-sm-10">
                        <input
                          type="text"
                          v-model="system.logo_title_1"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1 control-label"
                        >Số điện thoại</label
                      >
                      <div class="col-sm-3">
                        <input
                          type="number"
                          v-model="system.phone"
                          min="0"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1 control-label">Email</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          v-model="system.email"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <!--header_title-->
                    <div class="form-group">
                      <label class="col-sm-1 control-label">Tiêu đề</label>
                      <div class="col-sm-10">
                        <input
                          type="text"
                          v-model="system.header_title"
                          class="form-control"
                        />
                      </div>
                    </div>
                  </validation-observer>
                  <validation-observer
                    ref="observerBanner"
                    @submit.prevent="_submitInfo"
                  >
                    <div
                      class="form-group"
                      :style="{ backgroundColor: system.content_backgd_logo }"
                    >
                      <label class="col-sm-1 control-label">Banner</label>
                      <div class="col-sm-1">
                        <span class="btn btn-default" @click="_selectImage">
                          <i class="fa fa-image fa-fw" />
                        </span>
                      </div>
                      <div class="col-sm-8">
                        <img
                          :src="_getImageAvatar('banner')"
                          class="img"
                          style="width: 666px; height: 80px; object-fit: cover"
                        />
                      </div>
                      <div class="col-sm-2">
                        <div class="pull-right">
                          <button
                            type="button"
                            @click="_submitInfo"
                            data-toggle="tooltip"
                            title="Cập nhật"
                            class="btn btn-primary"
                          >
                            <i class="fa fa-save"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div
                      class="form-group"
                      :style="{
                        backgroundColor: system.content_background_color,
                      }"
                    >
                      <label class="col-sm-1 control-label"
                        >Màu nền nội dung</label
                      >
                      <div class="col-sm-10">
                        <input
                          type="text"
                          v-model="system.content_background_color"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div
                      class="form-group"
                      :style="{ backgroundColor: system.content_backgd_logo }"
                    >
                      <label class="col-sm-1 control-label"
                        >Màu nền tiêu đề</label
                      >
                      <div class="col-sm-3">
                        <input
                          type="text"
                          v-model="system.content_backgd_header_title"
                          class="form-control"
                        />
                      </div>
                      <label
                        class="col-sm-7 control-label"
                        style="color: #fff; text-align: center; line-height: 3"
                        :style="{
                          backgroundColor: system.content_backgd_header_title,
                        }"
                        >{{ system.header_title }}</label
                      >
                    </div>
                    <div
                      class="form-group"
                      :style="{ backgroundColor: system.content_backgd_logo }"
                    >
                      <div
                        :style="{
                          backgroundColor: system.content_backgd_header_title,
                        }"
                      >
                        <label class="col-sm-1 control-label"
                          >Màu nền Phone</label
                        >
                        <div class="col-sm-3">
                          <input
                            type="text"
                            v-model="system.content_backgd_phone"
                            class="form-control"
                          />
                        </div>
                        <label
                          class="col-sm-7 control-label"
                          style="
                            color: #fff;
                            text-align: center;
                            line-height: 3;
                          "
                          :style="{
                            backgroundColor: system.content_backgd_phone,
                          }"
                          >{{ system.phone }}</label
                        >
                      </div>
                    </div>
                    <div
                      class="form-group"
                      :style="{ backgroundColor: system.content_backgd_logo }"
                    >
                      <label class="col-sm-1 control-label">Màu nền Logo</label>
                      <div class="col-sm-3">
                        <input
                          type="text"
                          v-model="system.content_backgd_logo"
                          class="form-control"
                        />
                      </div>
                      <label
                        class="col-sm-7 control-label"
                        style="color: #fff; text-align: center; line-height: 3"
                        :style="{ backgroundColor: system.content_backgd_logo }"
                        ><div
                          class="file animated fadeIn"
                          style="height: 104px; border: none"
                        >
                          <div class="file-preview">
                            <img :src="_getImageAvatar('logo')" class="thumb" />
                          </div></div
                      ></label>
                    </div>
                  </validation-observer>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { fn_get_href_base_url, } from '@app/api/utils/fn-helper'
import Breadcrumb from 'com@admin/Breadcrumb'
import { MODULE_MODULE_APP, } from 'store@admin/types/module-types'
import {
  ACTION_SET_IMAGE,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_GET_SETTING,
} from 'store@admin/types/action-types'

export default {
  name: 'SystemPage',
  components: {
    Breadcrumb,
  },
  data() {
    const mm = new MM({
      el: '#modal-general-info-manager',
      api: {
        baseUrl: window.origin + '/api/mmedia',
        listUrl: 'list',
        uploadUrl: 'upload',
      },
      onSelect: (fi) => {
        if (typeof fi === 'object') {
          if (Object.keys(fi)[0] === 'selected' && fi['selected']) {
            const pathImg = 'Image/NewPicture/'
            if ((String(fi.selected['path']) !== 'undefined') && (String(fi.selected['path']).length > 3)) {
              if (this.mm.options._selfCom.fn) {
                this.mm.options._selfCom.fn(pathImg + fi.selected.path, fi.selected)
              } else {
                if (typeof this.mm.options._selfCom.setImage == 'function') {
                  this.mm.options._selfCom.setImage(pathImg + fi.selected.path)
                }
              }
              document.getElementById('media-file-manager-content').style =
                'display:none'
            }
          }
        }
      },
      _selfCom: this,
    })
    
    return {
      fullPage: false,
      media: {},
      fn: null,
      mm: mm,
    }
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  computed: {
    ...mapState(MODULE_MODULE_APP, {
      loading: (state) => state.loading,
      errors: (state) => state.errors,
    }),
    ...mapGetters(MODULE_MODULE_APP, ['system', 'updateSuccess']),
    _errors() {
      return this.errors.length
    },
    _getImageAvatar: (app) => (key) => {
      if (app.system.banner_image != '' && key == 'banner') {
        return fn_get_href_base_url(app.system.banner_image)
      } else if (app.system.logo_image != '' && key == 'logo') {
        return fn_get_href_base_url(app.system.logo_image)
      }

      return '/images/no-photo.jpg'
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_APP, {
      setImage: ACTION_SET_IMAGE,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
      getSetting: ACTION_GET_SETTING,
      updateBanner: 'ACTION_UPDATE_BANNER',
      updateLogo: 'ACTION_UPDATE_LOGO',
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
      this.$refs.observerBanner.validate().then(isValid => {
        if (isValid) {
          this.updateBanner()
        }
      })
    },
    _submitLogoInfo() {
      this.$refs.observerLogo.validate().then(isValid => {
        if (isValid) {
          this.updateLogo()
        }
      })
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification('')
    },
    _selectImage() {
      this.fn = null
      document.getElementById('media-file-manager-content').style =
        'display:block'
    },
    _selectLogoImage() {
      this.fn = this.updateLogo
      document.getElementById('media-file-manager-content').style =
        'display:block'
    },
  },
  setting: {
    title: 'Cập nhật hệ thống',
    error_msg_system: 'Lỗi hệ thống !',
  },
  mounted() {
    this.getSetting()
  },
}
</script>

<style>
#media-file-manager-content {
  position: absolute;
  z-index: 999999;
  top: 15px;
  right: 0px;
}
</style>