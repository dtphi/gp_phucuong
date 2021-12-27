<template>
  <div class="panel panel-default" style="height: 100%; overflow: auto">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-edit"></i>Cập nhật lễ chính</h3>
      <div slot="top-right" class="pull-right">
        <button @click="_hideModalEdit">❌</button>
      </div>
    </div>
    <div class="panel-body">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="input-info-name" class="col-sm-2 control-label">Mã</label>
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="info.code"
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
            >Tên lễ</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_name"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="info.name"
                type="text"
                id="input-info-name"
                class="form-control"
              />

              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
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
import { MODULE_MODULE_LE_CHINH_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'

export default {
  name: 'TheModalEdit',
  props: {
    info: {
      type: Object,
      require: true,
      validator: value => {
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
    ...mapState(MODULE_MODULE_LE_CHINH_EDIT, ['loading', 'updateSuccess']),
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LE_CHINH_EDIT, {
      updateInfo: ACTION_UPDATE_INFO,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    _hideModalEdit() {
      this.$modal.hide('modal-le-chinh-edit')
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
