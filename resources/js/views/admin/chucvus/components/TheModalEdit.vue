<template>
  <div class="panel panel-default" style="height: 100%; overflow: auto">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-edit"></i>Cập nhật chức vụ</h3>
      <div slot="top-right" class="pull-right">
        <button @click="_hideModalEdit">❌</button>
      </div>
    </div>
    <div class="panel-body">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label"
            >Tên chức vụ</label
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
            >Loại chức vụ</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:200"
              v-slot="{ errors }"
            >
              <select class="form-control" v-model="type_giao_xu">
                <option
                  :selected="item.type_giao_xu == idx"
                  :value="idx ? idx : ''"
                  v-for="(item, idx) in $options.setting.cf.loaiChucVus"
                  :key="idx"
                >
                  {{ item }}
                </option>
              </select>
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
                v-model="sort_id"
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
            >Văn thư bổ nhiệm</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_vtbn"
              rules="max:200"
              v-slot="{ errors }"
            >
              <textarea class="form-control" v-model="vtbn"></textarea>
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
import { MODULE_MODULE_CHUC_VU_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import { config, } from '@app/common/config'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_CHUC_VUS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_MODULE_CHUC_VU_EDIT}/getInfoField`,
  mutationType: `${MODULE_MODULE_CHUC_VU_EDIT}/updateInfoField`,
})

export default {
  name: 'TheModalEdit',
  data() {
    return {
      fullPage: false,
    }
  },
  computed: {
    ...mapFields(MAP_PC_CHUC_VUS),
    ...mapState(MODULE_MODULE_CHUC_VU_EDIT, ['info', 'loading', 'updateSuccess']),
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_CHUC_VU_EDIT, [
      ACTION_UPDATE_INFO,
      ACTION_RESET_NOTIFICATION_INFO
    ]),
    _hideModalEdit() {
      this.$modal.hide('modal-chuc-vu-edit')
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
