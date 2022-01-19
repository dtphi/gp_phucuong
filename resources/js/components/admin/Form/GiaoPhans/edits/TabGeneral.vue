<template>
  <div class="tab-content">
    <div class="form-group required">
      <label for="input-info-name" class="col-sm-2 control-label">{{
        $options.setting.name_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_name"
          rules="required|max:255"
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
            <img :src="_getImageAvatar" class="thumb" />
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-khai-quat" class="col-sm-2 control-label"
        >Khái quát</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_khai_quat"
          rules="max:500"
          v-slot="{ errors }"
        >
          <tinymce
            id="input-info-khai-quat"
            :other_options="options"
            v-model="groupData.khai_quat"
          ></tinymce>

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
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
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-status"
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
    <div class="form-group">
      <label for="input-info-meta-title" class="col-sm-2 control-label">{{
        $options.setting.info_meta_title_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_title"
          rules="max:255"
          v-slot="{ errors }"
        >
          <input
            id="input-info-meta-title"
            v-model="groupData.meta_title"
            class="form-control"
            :placeholder="$options.setting.info_meta_title_txt"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-meta-description" class="col-sm-2 control-label">{{
        $options.setting.info_meta_description_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_description"
          rules="max:500"
          v-slot="{ errors }"
        >
          <textarea
            id="input-info-meta-description"
            v-model="groupData.meta_description"
            class="form-control"
            :placeholder="$options.setting.info_meta_description_txt"
          ></textarea>

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-meta-keyword" class="col-sm-2 control-label">{{
        $options.setting.info_key_word_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_keyword"
          rules="max:500"
          v-slot="{ errors }"
        >
          <textarea
            id="input-info-meta-keyword"
            v-model="groupData.meta_keyword"
            class="form-control"
            :placeholder="$options.setting.info_key_word_txt"
          ></textarea>

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-tag" class="col-sm-2 control-label">
        <span
          data-toggle="tooltip"
          :data-original-title="$options.setting.info_tag_tooltip_txt"
          >{{ $options.setting.info_tag_txt }}</span
        >
      </label>
      <div class="col-sm-10">
        <validation-provider
          name="info_tag"
          rules="max:255"
          v-slot="{ errors }"
        >
          <input
            id="input-info-tag"
            v-model="groupData.tag"
            class="form-control"
            :placeholder="$options.setting.info_tag_txt"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import { config, } from '@app/common/config'
import tinymce from 'vue-tinymce-editor'
import { MODULE_MODULE_GIAO_PHAN_EDIT, } from 'store@admin/types/module-types'
import { ACTION_SET_IMAGE, } from 'store@admin/types/action-types'
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
      editor: null,
      fn: null,
      mm: mm,
      options: options,
    }
  },
  computed: {
    _getImageAvatar() {
      if (this.groupData?.image != '' && this.groupData?.image) {
        return this.groupData.image
      }

      return '/images/no-photo.jpg'
    },
  },
  watch: {
    groupData: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
        if (Object.keys(newValue).length) {
          return (newValue.khaiquat =
            newValue.khaiquat === null ? '' : newValue.khaiquat)
        }
      },
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [ACTION_SET_IMAGE]),
    _selectImage() {
      this.fn = function(file) {
        const _self = this
        _self.setImage(file)
      }
      document.getElementById('media-file-manager-content').style = this.$options.setting.cssDisplay
    },
  },
  setting: {
    cssDisplay: 'display:block',
    cssDisplayNone: 'display:none',
    name_txt: 'Tên',
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
