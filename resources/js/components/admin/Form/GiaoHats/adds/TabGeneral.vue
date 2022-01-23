<template>
  <div class="tab-content">
    <!-- Tên hạt -->
    <div class="form-group required">
      <label for="input-info-name" class="col-sm-2 control-label">{{
        $options.setting.name_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_name_hat"
          rules="required|max:50"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.name"
            type="text"
            id="input-info-name"
            class="form-control"
            :placeholder="$options.setting.name_txt"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Khái quát khu vực -->
    <div class="form-group">
      <label for="input-info-khu-vuc" class="col-sm-2 control-label"
        >Khu vực</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_khu_vuc"
          rules="max:500"
          v-slot="{ errors }"
        >
          <tinymce
            id="input-info-khu-vuc"
            :other_options="options"
            v-model="groupData.khu_vuc"
          ></tinymce>

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Người quản hạt -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-nguoiquanhat"
        >Người quản hạt</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_nguoiquanhat"
          rules="max:50"
          v-slot="{ errors }"
        >
          <select v-model="groupData.nguoi_quan_hat">
            <option
              v-for="option in isLinhMuc"
              v-bind:value="option.id"
              :key="option.id"
            >
              {{ option.ten }}
            </option>
          </select>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Trạng thái -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-active"
        >Trạng thái</label
      >
      <div class="col-sm-10">
        <select
          v-model="groupData.active"
          id="input-info-active"
          class="form-control"
        >
          <option value="1" selected="selected">Xảy ra</option>
          <option value="0">Ẩn</option>
        </select>
      </div>
    </div>
    <!-- Phân loại -->
    <div class="form-group">
      <label for="input-info-phanloai" class="col-sm-2 control-label"
        >Phân loại</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_title"
          rules="max:255"
          v-slot="{ errors }"
        >
          <input
            id="input-info-phanloai"
            v-model="groupData.phan_loai"
            class="form-control"
            placeholder="Phân loại"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Sort_id -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-sort-order"
        >Thứ tự</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="sort_order"
          rules="numeric|max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="groupData.sort_id"
            name="sort_order"
            placeholder="Thứ tự hiển thị"
            id="input-info-sort-order"
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
import tinymce from 'vue-tinymce-editor'
import { MODULE_MODULE_GIAO_HAT_ADD, } from 'store@admin/types/module-types'
import { fnCheckImgPath, } from '@app/common/util'

export default {
  name: 'TabGeneralForm',
  components: {
    tinymce,
  },
  props: {
    groupData: {
      type: Object,
    },
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_HAT_ADD, {
      isLinhMuc: (state) => {
        return state.linhMuc
      },
    }),
  },
  data() {
    const elFileContent = document.getElementById('media-file-manager-content')
    const mm = new MM({
      el: '#modal-general-info-manager',
      api: this.$cmsCfg.mm.api,
      onSelect: (fi) => {
        if (typeof fi === 'object') {
          if (fnCheckImgPath(fi)) {
            this.fn(`/${this.$cmsCfg.dirImage}/${fi.selected.path}`, fi.selected)
            elFileContent.style = this.$options.setting.cssDisplayNone
          }
        }
      },
    })
    const options = this.$cmsCfg.tinymce.options((callback) => {
      this.fn = callback
      elFileContent.style = this.$options.setting.cssDisplay
    })

    return {
      editor: null,
      fn: null,
      mm: mm,
      options: options,
    }
  },
  watch: {
    groupData: {
      immediate: true,
      deep: true,
      handler(newValue) {
        if (Object.keys(newValue).length) {
          return (newValue.khu_vuc =
            newValue.khu_vuc === null ? '' : newValue.khu_vuc)
        }
      },
    },
  },
  setting: {
    cssDisplay: 'display:block',
    cssDisplayNone: 'display:none',
    name_txt: 'Tên hạt',
    info_sort_description_txt: 'Mô tả',
    info_description_txt: 'Nội dung',
    info_key_word_txt: 'Từ khóa mô tả',
    info_meta_title_txt: 'Thẻ meta tiêu đề',
    info_meta_description_txt: 'Thẻ meta mô tả',
    info_tag_txt: 'Tags',
    info_tag_tooltip_txt: 'Ngăn cách bởi dấu phẩy',
  },
}
</script>
