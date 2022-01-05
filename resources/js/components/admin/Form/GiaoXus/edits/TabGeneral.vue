<template>
  <div class="tab-content">
    <!-- Image -->
    <div class="form-group">
      <label for="input-info-duc-cha" class="col-sm-2 control-label"
        >Hình ảnh</label
      >
      <div class="col-sm-2">
        <input
          @click="_selectImage"
          type="button"
          value="Image"
          id="input-info-image"
          class="form-control"
        />
      </div>
      <div class="col-sm-3">
        <div class="file animated fadeIn" style="height: 61px">
          <div class="file-preview">
            <img :src="_image" class="thumb" />
          </div>
        </div>
      </div>
    </div>
    <!-- Tên giáo xứ -->
    <div class="form-group required">
      <label for="input-info-name" class="col-sm-2 control-label"
        >Tên giáo xứ</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_name_hat"
          rules="required|max:50"
          v-slot="{ errors }"
        >
          <input
            v-model="name"
            type="text"
            id="input-info-name"
            class="form-control"
            placeholder="Tên giáo xứ"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-ngay-thanh-lap" class="col-sm-2 control-label"
        >Ngày thành lập</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_ngay_thanh_lap"
          rules="max:50"
          v-slot="{ errors }"
        >
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="ngay_thanh_lap"
          id="input-ngay-thanh-lap"
          type="date"
        ></cms-date-picker>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Giáo xứ thuộc giáo hạt -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-giaohat"
        >Thuộc giáo hạt</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_giaohat"
          rules="max:50"
          v-slot="{ errors }"
        >
          <select v-model="giao_hat_id" class="form-control">
            <option
              v-for="item in isGiaoHat"
              v-bind:value="item.id"
              :key="item.id"
            >
              {{ item.name }}
            </option>
          </select>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
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
            v-model="dia_chi"
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
          rules="max:12"
          v-slot="{ errors }"
        >
          <input
            v-model="dien_thoai"
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
            v-model="email"
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
            v-model="active"
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
    <!-- Dân số -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-danso"
        >Dân số</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_danso"
          rules="max:10"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="dan_so"
            placeholder="Dân số"
            id="input-info-danso"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Số tín hữu -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-sotinhuu"
        >Số tín hữu</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_sotinhuu"
          rules="max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="so_tin_huu"
            placeholder="Số tín hữu"
            id="input-info-sotinhuu"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Giờ lễ -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-gio-le"
        >Giờ lễ</label
      >
      <div class="col-sm-10">
        <tinymce
          id="input-info-gio-lec"
          :other_options="options"
          v-model="gio_le"
        ></tinymce>
      </div>
    </div>
    <!-- Viet -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-viet">Việt</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_viet"
          rules="max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="viet"
            placeholder="Việt"
            id="input-info-viet"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Latin -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-latin">Latin</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_latin"
          rules="max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="latin"
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
      <label class="col-sm-2 control-label" for="input-info-noi-dung"
        >Nội dung</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_dung"
          rules="required"
          v-slot="{ errors }"
        >
          <tinymce
            id="input-info-noi-dung"
            :other_options="options"
            v-model="noi_dung"
          >
          </tinymce>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Type -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-type">Type</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_type"
          rules="max:255"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="type"
            placeholder="Type"
            id="input-info-type"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import { config, } from '@app/common/config'
import tinymce from 'vue-tinymce-editor'
import {
  fn_get_href_base_url,
} from '@app/api/utils/fn-helper'
import { MODULE_MODULE_GIAO_XU_EDIT, } from 'store@admin/types/module-types'
import { ACTION_SET_IMAGE, } from 'store@admin/types/action-types'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_GIAO_XUS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_MODULE_GIAO_XU_EDIT}/getInfoField`,
  mutationType: `${MODULE_MODULE_GIAO_XU_EDIT}/updateInfoField`,
})

export default {
  name: 'TabGeneralForm',
  components: {
    tinymce,
  },
  props: {
    media: {
      type: Object,
    },
    mmSelected: {
      default() {
        return {}
      },
    },
    mmPath: {
      type: String,
      default() {
        return ''
      },
    },
  },
  data() {
    const elFileContent = document.getElementById('media-file-manager-content')
    const options = config.tinymce.options((callback) => {
      this.fn = callback
      elFileContent.style = this.$options.setting.cssDisplay
    })

    return {
      fn: null,
      options: options,
    }
  },
  watch: {
    mmPath(val) {
      this._updateImageField(val)
    },
  },
  computed: {
    ...mapFields(MAP_PC_GIAO_XUS),
    ...mapState(MODULE_MODULE_GIAO_XU_EDIT, {
      isGiaoHat: (state) => {
        return state.listGiaoHat
      },
      groupData: state => state.info,
      
    }),
    _image() {
      return fn_get_href_base_url(this.groupData?.image ? this.groupData.image :this.mmPath)
    },
    _errors() {
      return this.errors?.length
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_XU_EDIT, [ACTION_SET_IMAGE]),
    _selectImage() {
      this.fn = null
      document.getElementById('media-file-manager-content')
        .style = this.$options.setting.cssDisplay
    },
    _updateImageField(path) {
      if (typeof this.fn === 'function') {
        this.fn(path, this.mmSelected)
      } else {
        this[ACTION_SET_IMAGE](path)
      }
    },
  },
  setting: {
    cssDisplay: 'display: block;',
  },
}
</script>
