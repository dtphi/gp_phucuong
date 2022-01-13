<template>
  <the-modal-resizable
    :title="$options.setting.modal_title"
    :modal-name="$options.setting.modal_name"
  >
    <template #cms_modal_form_group>
        <div class="form-group">
          <label class="col-sm-2 control-label"
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
                class="form-control"
              />
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"
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
          <label class="col-sm-2 control-label"
            >Sắp xếp</label
          >
          <div class="col-sm-10">
            <validation-provider
              name="info_sap_xep"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                v-model="sort_id"
                type="number"
                class="form-control"
              />
              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"
            >Văn thư bổ nhiệm</label
          >
          <div class="col-sm-10">
            <tinymce
              :id="`input-van-thu-bo-nhiem-edit-${id}`"
              :other_options="options"
              v-model="vtbn"
            ></tinymce>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"
            >Trạng thái</label
          >
          <div class="col-sm-10">
            <select class="form-control" v-model="active">
              <option value="1" :selected="active == 1">Xảy ra</option>
              <option value="0" :selected="active == 0">Ẩn</option>
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
          value="Cập nhật"
          class="btn btn-primary"
          @click.prevent="_submitUpdate"
        />
    </template>
  </the-modal-resizable>
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
import TheModalResizable from 'com@admin/Modal/TheModalResizable'
import tinymce from 'vue-tinymce-editor'
import { fnCheckImgPath, } from '@app/common/util'

export default {
  name: 'TheModalEdit',
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
      fullPage: false,
      fn: null,
      mm: mm,
      options: options,
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
      ACTION_RESET_NOTIFICATION_INFO,
      'ACTION_RESET_INFO_ITEM'
    ]),
    _hideModalEdit() {
      this.$modal.hide('modal-chuc-vu-edit')
    },
    async _submitUpdate() {
      await this[ACTION_UPDATE_INFO](this.info)
      this.ACTION_RESET_INFO_ITEM()
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
    modal_title: 'Thêm Chức Vụ',
    modal_name: 'modal-chuc-vu-edit',
  },
}
</script>
