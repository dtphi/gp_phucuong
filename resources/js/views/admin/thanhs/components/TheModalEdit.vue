<template>
  <div class="panel panel-default" style="height: 100%; overflow: auto">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-edit"></i>Cập nhật tên thánh</h3>
      <div slot="top-right" class="pull-right">
        <button @click="_hideModalEdit">❌</button>
      </div>
    </div>
    <div class="panel-body">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Tên thánh</label
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
          <label for="input-info-name" class="col-sm-2 control-label"
            >Latin</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="latin"
                type="text"
                id="input-info-name"
                class="form-control"
              />
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Bổn mạng</label
          >
          <div class="col-sm-10">
            <cms-date-picker
              value-type="format"
              format="YYYY-MM-DD"
              v-model="bon_mang"
              type="date"
            ></cms-date-picker>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
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
          <label for="input-info-name" class="col-sm-2 control-label"
            >Cuộc đời</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_ghi_chu"
              rules="max:200"
              v-slot="{ errors }"
            >
              <textarea class="form-control" v-model="cuoc_doi"></textarea>
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
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
import { MODULE_MODULE_THANH_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_THANHS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_MODULE_THANH_EDIT}/getInfoField`,
  mutationType: `${MODULE_MODULE_THANH_EDIT}/updateInfoField`,
})

export default {
  name: 'TheModalEdit',
  data() {
    return {
      fullPage: false,
    }
  },
  computed: {
    ...mapFields(MAP_PC_THANHS),
    ...mapState(MODULE_MODULE_THANH_EDIT, ['info', 'loading', 'updateSuccess']),
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_THANH_EDIT, {
      updateInfo: ACTION_UPDATE_INFO,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    _hideModalEdit() {
      this.$modal.hide('modal-thanh-edit')
    },
    _submitUpdate() {
      this.updateInfo(this.info)
      
      return 0
    },
    _notificationUpdate(notification) {
      if (notification.type == 'success') {
        this.$emit('update-info-success')
      }
      this.$notify(notification)
      this.resetNotification()
    },
  },
  setting: {
    list_title: 'Danh sách Linh mục',
  },
}
</script>
