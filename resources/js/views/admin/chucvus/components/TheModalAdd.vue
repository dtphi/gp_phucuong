<template>
  <the-modal-resizable
    :title="$options.setting.modal_title"
    :modal-name="$options.setting.modal_name"
  >
    <template #cms_modal_form_group>
      <div class="form-group">
        <label class="col-sm-3 control-label">Tên chức vụ</label>
        <div class="col-sm-9">
          <validation-provider
            name="info_name"
            rules="max:255"
            v-slot="{ errors }"
          >
            <input v-model="info.name" type="text" class="form-control" />
            <span class="cms-text-red">{{ errors[0] }}</span>
          </validation-provider>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Loại chức vụ</label>
        <div class="col-sm-9">
          <validation-provider
            name="info_loai_chuc_vu"
            rules="max:200"
            v-slot="{ errors }"
          >
            <select class="form-control" v-model="info.type_giao_xu">
              <option
                :selected="item.type_giao_xu == idx"
                :value="idx"
                v-for="(item, idx) in $cmsCfg.loaiChucVus"
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
        <label class="col-sm-3 control-label">Sắp xếp</label>
        <div class="col-sm-9">
          <validation-provider
            name="info_sap_xep"
            rules="max:255"
            v-slot="{ errors }"
          >
            <input v-model="info.sort_id" type="number" class="form-control" />
            <span class="cms-text-red">{{ errors[0] }}</span>
          </validation-provider>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Văn thư bổ nhiệm</label>
        <div class="col-sm-9">
          <tinymce
            id="input-info-bo-nhiem"
            :other_options="options"
            v-model="info.vtbn"
          ></tinymce>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Trạng thái</label>
        <div class="col-sm-9">
          <select class="form-control" v-model="info.active">
            <option value="1" :selected="info.active == 1">Xảy ra</option>
            <option value="0" :selected="info.active == 0">Ẩn</option>
          </select>
        </div>
      </div>
    </template>
    <template #cms_modal_btn_group>
      <input
        type="button"
        value="Đóng"
        class="btn btn-default"
        @click="_hideModalEdit"
      />
      <input
        type="button"
        value="Thêm"
        class="btn btn-primary"
        @click.prevent="_submitUpdate"
      />
    </template>
  </the-modal-resizable>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import { config } from '@app/common/config'
import TheModalResizable from 'com@admin/Modal/TheModalResizable'
import tinymce from 'vue-tinymce-editor'
import { fnCheckImgPath } from '@app/common/util'
import { MODULE_MODULE_CHUC_VU_ADD } from 'store@admin/types/module-types'
import {
  ACTION_INSERT_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'

export default {
  name: 'TheModalAdd',
  components: {
    tinymce,
    TheModalResizable,
  },
  data() {
    const elFileContent = document.getElementById('media-file-manager-content')
    const mm = new MM({
      el: '#modal-general-info-manager',
      api: config.mm.api,
      onSelect: (fi) => {
        if (typeof fi === 'object') {
          if (fnCheckImgPath(fi)) {
            this.fn(`/${config.dirImage}/${fi.selected.path}`, fi.selected)
            elFileContent.style = this.$options.setting.cssDisplayNone
          }
        }
      },
    })
    const options = config.tinymce.options((callback) => {
      this.fn = callback
      elFileContent.style = this.$options.setting.cssDisplay
    })

    return {
      fn: null,
      mm: mm,
      options: options,
      info: {
        active: 1,
        vtbn: '',
        id: null,
        name: '',
        sort_id: 0,
        type_giao_xu: 0,
      },
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_CHUC_VU_ADD, [
      'loading',
      'insertSuccess',
    ]),
  },
  watch: {
    insertSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_CHUC_VU_ADD, [
      ACTION_INSERT_INFO,
      ACTION_RESET_NOTIFICATION_INFO,
    ]),
    _hideModalEdit() {
      this.$modal.hide('modal-chuc-vu-add')
    },
    async _submitUpdate() {
      await this[ACTION_INSERT_INFO](this.info)
    },
    _notificationUpdate(notification) {
      if (notification.type == 'success') {
        this.$emit('add-info-success')
      }
      this.$notify(notification)
      this[ACTION_RESET_NOTIFICATION_INFO]()
    },
  },
  setting: {
    cssDisplay: 'display:block',
    cssDisplayNone: 'display:none',
    modal_title: 'Thêm Chức Vụ',
    modal_name: 'modal-chuc-vu-add',
    keyChucVu: 'chuc_vu',
  },
}
</script>
