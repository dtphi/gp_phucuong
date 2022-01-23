<template>
  <div class="tab-content">
    <!-- Tên dòng -->
    <div class="form-group required">
      <label for="input-info-name" class="col-sm-2 control-label"
        >Tên dòng</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_name_dong"
          rules="required|max:100"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.name"
            type="text"
            id="input-info-name"
            class="form-control"
            placeholder="Tên dòng"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Giáo xứ thuộc giáo phận -->
    <!--<div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-giaophan"
        >Thuộc giáo phận</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_giaophan"
          rules="max:50"
          v-slot="{ errors }"
        >
          <select v-model="groupData.giaophan_id" class="form-control">
            <option
              v-for="item in isGiaoPhan"
              v-bind:value="item.id"
              :key="item.id"
            >
              {{ item.name }}
            </option>
          </select>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>-->
    <!-- Địa chỉ-->
    <div class="form-group">
      <label for="input-info-dia-chi" class="col-sm-2 control-label"
        >Địa chỉ</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_dia_chi"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.dia_chi"
            type="text"
            id="input-info-diachi"
            class="form-control"
            placeholder="Địa chỉ"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Điện thoại -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-dien-thoai"
        >Điện thoại</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_dien_thoai"
          rules="max:50"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.dien_thoai"
            type="text"
            id="input-info-dien-thoai"
            class="form-control"
            placeholder="Điện thoại"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Email -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-email">Email</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_email"
          rules="max:50|email"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.email"
            type="email"
            id="input-info-email"
            class="form-control"
            placeholder="Email"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Active -->
    <div class="form-group">
      <label for="input-info-active" class="col-sm-2 control-label"
        >Trạng thái</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_active"
          rules="max:255"
          v-slot="{ errors }"
        >
          <select
            v-model="groupData.active"
            id="input-info-active"
            class="form-control"
          >
            <option value="1" selected="selected">Xảy ra</option>
            <option value="0">Ẩn</option>
          </select>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Viet -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-viet">Việt</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_viet"
          rules="required|max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="groupData.viet"
            placeholder="Việt"
            id="input-info-viet"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Latin -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-latin">Latin</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_latin"
          rules="required|max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="groupData.latin"
            placeholder="Latin"
            id="input-info-latin"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Nội dung -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-noidung"
        >Nội dung</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_dung"
          rules="required|max:255"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="groupData.noi_dung"
            placeholder="Nội dung"
            id="input-info-noidung"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, } from 'vuex'
import { MODULE_MODULE_DONG_ADD, } from 'store@admin/types/module-types'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'TabGeneralFormAddDong',
  props: {
    groupData: {
      type: Object,
    },
  },
  computed: {
    ...mapState(MODULE_MODULE_DONG_ADD, {
      isGiaoPhan: (state) => {
        return state.listGiaoPhan
      },
    }),
  },
  data() {
    const _self = this

    return {
      editor: null,
      fn: null,
      mm: new MM({
        el: '#modal-general-info-manager',
        api: this.$cmsCfg.mm.api,
        onSelect: (fi) => {
          if (typeof fi === 'object') {
            if (fnCheckProp(fi, 'selected') && fi.selected) {
              if (fnCheckProp(fi.selected, 'path')) {
                if (_self.fn) {
                  _self.fn('Image/NewPicture/' + fi.selected.path, fi.selected)
                }
                document.getElementById('media-file-manager-content').style =
                  'display:none'
              }
            }
          }
        },
      }),
      options: {
        language_url: this.$cmsCfg.mm.languageUrl,
        height: this.$cmsCfg.mm.height,
        image_prepend_url: this.$cmsCfg.mm.imagePrependUrl,
        file_picker_callback: (callback, value, meta) => {
          _self.media.options._selfCom = _self
          if (_self.$cmsCfg.mm.fileTypes.includes(meta.filetype)) {
            _self.fn = callback
            elFileContent.style = _self.$options.setting.cssDisplay
          }
        },
        referrer_policy: this.$cmsCfg.mm.referrerPolicy,
        toolbar2: this.$cmsCfg.mm.toolbar2,
        font_formats:this.$cmsCfg.mm.fontFormats,
      },
    }
  },
  watch: {
    groupData: {
      immediate: true,
      deep: true,
      handler(newValue) {
        if (Object.keys(newValue).length) {
          return (newValue.khuvuc =
            newValue.khuvuc === null ? '' : newValue.khuvuc)
        }
      },
    },
  },
  setting: {
  },
}
</script>
