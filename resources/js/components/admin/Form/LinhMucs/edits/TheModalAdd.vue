<template>
  <modal name="modal-ho-so-add" :height="255">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-heading">
        <h3 class="panel-title">
          <i class="fa fa-plus"></i>Thêm thư mục mới
        </h3>
        <div slot="top-right" class="pull-right">
          <button type="button" @click="_hideModalEdit">❌</button>
        </div>
      </div>
      <div class="panel-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Tên</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_new_folder_name"
                rules="max:200"
                v-slot="{ errors }"
              >
                <input
                  class="form-control"
                  v-model="info.new_folder_name"
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
            value="Tạo"
            class="btn btn-primary"
            @click.prevent="_submitCreate"
          />
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { mapActions, mapState, } from 'vuex'
import { MODULE_MODULE_THUYEN_CHUYEN_ADD, } from 'store@admin/types/module-types'
import { ACTION_RESET_NOTIFICATION_INFO, } from 'store@admin/types/action-types'
import {
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
  import axios from 'axios'

export default {
  name: 'TheModalAdd',
  props: {
		linhmucId: {
			default() {
				return 0
			}
		},
    dirQuery: {
      default() {
        return 'AllFiles'
      }
    }
	},
  data() {
    return {
      info: {
        new_folder_name: 'Thư mục mới'
      },
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_THUYEN_CHUYEN_ADD, ['loading', 'insertSuccess']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_THUYEN_CHUYEN_ADD, {
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    _hideModalEdit() {
      this.info.new_folder_name = 'Thư mục mới'
      this.$modal.hide('modal-ho-so-add')
    },
    _submitCreate() {
      let loadUrl = fn_get_base_api_detail_url('/api/linh-mucs', this.linhmucId + '?_type=hoso&action=new_dir&_dir=' + this.dirQuery + '&new_dir_name=' + this.info.new_folder_name)
        axios.get(loadUrl)
        .then((response) => {
          if (response.status === 200) {
            this.$emit('update-success')
            this._hideModalEdit()
          }
        })
        .catch(errors => {
          if (errors.response) {
            console.log(errors)
          }
        })
    },
    _changeForm(values, type) {
      this.$emit('change-form', { ...values, type, })
    },
    _notificationUpdate(notification) {
      if (notification.type == 'success') {
        this.$emit('insert-info-success')
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
