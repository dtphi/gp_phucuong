<template>
  <div id="content">
    <template v-if="_errors">
      <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i>
        <button type="button" class="close" data-dismiss="alert">
          &times;
        </button>
        <h3 v-for="(err, idx) in _errorToArrs()" :key="idx">{{ err }}</h3>
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
            <info-edit-form ref="formEditGroupAlbums"></info-edit-form>
          </div>
        </div>
      </div>
    </validation-observer>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import InfoEditForm from "com@admin/Form/GroupAlbums/EditForm";
import Breadcrumb from "com@admin/Breadcrumb";
import TheBtnBackListPage from "./components/TheBtnBackListPage";
import { MODULE_MODULE_GROUP_ALBUMS_EDIT } from "store@admin/types/module-types";
import {
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_GET_INFO_BY_ID,
} from "store@admin/types/action-types";
import { fn_redirect_url } from "@app/api/utils/fn-helper";

export default {
  name: "GroupAlbumsEdit",
  beforeCreate() {
    const infoId = parseInt(this.$route.params.infoId);
    if (!infoId) {
      return fn_redirect_url("admin/group-albums");
    }
  },
  components: {
    Breadcrumb,
    TheBtnBackListPage,
    InfoEditForm,
  },
  data() {
    return {
      fullPage: true,
    };
  },
  computed: {
    ...mapState(MODULE_MODULE_GROUP_ALBUMS_EDIT, {
      loading: state => state.loading,
      errors: state => state.errors,
      updateSuccess: state => state.updateSuccess,
      info: state => state.info.data,
    }),
    _errors() {
      return this.errors.length;
    },
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue);
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GROUP_ALBUMS_EDIT, [
      ACTION_RESET_NOTIFICATION_INFO,
      ACTION_GET_INFO_BY_ID,
    ]),
    _errorToArrs() {
      let errs = [];
      if (
        this.errors.length &&
        typeof this.errors[0].messages !== "undefined"
      ) {
        errs = Object.values(this.errors[0].messages);
      }
      if (Object.entries(errs).length === 0 && this.errors.length) {
        errs.push(this.$options.setting.error_msg_system);
      }
      return errs;
    },
    _submitInfo() {
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formEditGroupAlbums._submitInfo();
        }
      });
    },
    _submitInfoBack() {
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formEditGroupAlbums._submitInfoBack();
        }
      });
    },
    _notificationUpdate(notification) {
      this.$notify(notification);
      this[ACTION_RESET_NOTIFICATION_INFO]("");
    },
  },
  setting: {
    panel_title: "Group Albums",
    frm_title: "Sửa Group Albums",
    btn_save_txt: "Lưu",
    btn_save_back_txt: "Lưu trở về danh sách",
    error_msg_system: "Group albums đã tồn tại",
  },
  mounted() {
    const infoId = parseInt(this.$route.params.infoId);
    if (infoId) {
      this[ACTION_GET_INFO_BY_ID](infoId);
    }
  },
};
</script>
