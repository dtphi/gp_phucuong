<template>
  <div class="panel panel-default" style="height: 100%; overflow: auto">
    <div class="panel-heading">
      <h3 class="panel-title">
        <i class="fa fa-edit"></i>Cập nhật công đoàn tu sĩ
      </h3>
      <div slot="top-right" class="pull-right">
        <button @click="_hideModalEdit">❌</button>
      </div>
    </div>
    <div class="panel-body">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="input-giao-hat-name" class="col-sm-2 control-label"
            >Giáo hạt</label
          >
          <div class="col-sm-10">
            {{ giao_hat_id }}
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Tên công đoàn</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="name"
                type="text"
                id="input-info-name"
                class="form-control"
              />
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-dia-chi" class="col-sm-2 control-label"
            >Địa chỉ</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_dia_chi"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="dia_chi"
                type="text"
                id="input-info-dia-chi"
                class="form-control"
              />
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-phone" class="col-sm-2 control-label"
            >Điện thoại</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_phone"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="dien_thoai"
                type="text"
                id="input-info-phone"
                class="form-control"
              />
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-ghi-chu" class="col-sm-2 control-label"
            >Ghi chú</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_ghi_chu"
              rules="max:200"
              v-slot="{ errors }"
            >
              <textarea class="form-control" v-model="ghi_chu"></textarea>
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-active" class="col-sm-2 control-label"
            >Trạng thái</label
          >
          <div class="col-sm-10">
            <select class="form-control" v-model="active">
              <option value="1" :selected="active == 1">Xảy ra</option>
              <option value="0" :selected="active == 0">Ẩn</option>
            </select>
          </div>
        </div>
      </form>
    </div>
    <div class="container-fluid">
      <div class="pull-right">
        <input
          type="button"
          value="Hủy"
          class="btn btn-default"
          @click="_hideModalEdit"
        />
        <input
          type="button"
          value="Cập nhật"
          class="btn btn-primary"
          @click.prevent="_submitUpdate"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState, } from 'vuex'
import { MODULE_MODULE_CONG_DOAN_TU_SI_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_CONG_DOAN_TU_SIS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_MODULE_CONG_DOAN_TU_SI_EDIT}/getInfoField`,
  mutationType: `${MODULE_MODULE_CONG_DOAN_TU_SI_EDIT}/updateInfoField`,
})

export default {
  name: 'TheModalEdit',
  data() {
    return {
      fullPage: false,
    }
  },
  computed: {
    ...mapFields(MAP_PC_CONG_DOAN_TU_SIS),
    ...mapState(MODULE_MODULE_CONG_DOAN_TU_SI_EDIT, [
      'info',
      'loading',
      'updateSuccess'
    ]),
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_CONG_DOAN_TU_SI_EDIT, [
      ACTION_UPDATE_INFO,
      ACTION_RESET_NOTIFICATION_INFO
    ]),
    _hideModalEdit() {
      this.$modal.hide('modal-cong-doan-tu-si-edit')
    },
    _submitUpdate() {
      this[ACTION_UPDATE_INFO](this.info)
      
      return 0
    },
    _notificationUpdate(notification) {
      if (notification.type == 'success') {
        this.$emit('update-info-success')
      }
      this.$notify(notification)
      this[ACTION_RESET_NOTIFICATION_INFO]()
    },
  },
  setting: {
    list_title: 'Danh sách Linh mục',
  },
}
</script>
