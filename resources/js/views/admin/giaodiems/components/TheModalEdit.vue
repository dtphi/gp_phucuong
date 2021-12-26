<template>
  <div class="panel panel-default" style="height: 100%; overflow: auto">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-edit"></i>Cập nhật giáo điểm</h3>
      <div slot="top-right" class="pull-right">
        <button @click="_hideModalEdit">❌</button>
      </div>
    </div>
    <div class="panel-body">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Giáo phận</label
          >
          <div class="col-sm-10">
            {{ info.ten_linh_muc }}
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Giáo hạt</label
          >
          <div class="col-sm-10">
            {{ info.ten_linh_muc }}
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Giáo xứ</label
          >
          <div class="col-sm-10">
            {{ info.ten_linh_muc }}
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Tên giáo điểm</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="info.nguoi_thu_phong"
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
            >Địa chỉ</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="info.noi_thu_phong"
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
            >Sắp xếp</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="info.noi_thu_phong"
                type="number"
                id="input-info-name"
                class="form-control"
              />
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
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
              <textarea class="form-control" v-model="info.ghi_chu"></textarea>
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Trạng thái</label
          >
          <div class="col-sm-10">
            <select class="form-control" v-model="info.active">
              <option value="1" :selected="info.active == 1">Xảy ra</option>
              <option value="0" :selected="info.active == 0">Ẩn</option>
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
import { MODULE_MODULE_GIAO_DIEM_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import { config, } from '@app/common/config'

export default {
  name: 'TheModalEdit',
  props: {
    info: {
      type: Object,
      require: true,
      validator: function(value) {
        return value.id && Number.isInteger(value.id)
      },
    },
  },
  data() {
    return {
      fullPage: false,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_DIEM_EDIT, ['loading', 'updateSuccess']),
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_DIEM_EDIT, [
      ACTION_UPDATE_INFO,
      ACTION_RESET_NOTIFICATION_INFO
    ]),
    _hideModalEdit() {
      this.$modal.hide('modal-giao-diem-edit')
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
    cf: config,
    list_title: 'Danh sách Linh mục',
  },
}
</script>
