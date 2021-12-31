<template>
  <div class="tab-content">
    <div class="form-group required">
      <label for="input-info-name" class="col-sm-2 control-label">{{
        $options.setting.name_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_name"
          rules="required|max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="generalData.name"
            type="text"
            id="input-info-name"
            class="form-control"
            :placeholder="$options.setting.name_txt"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group required">
      <label for="input-info-sort-description" class="col-sm-2 control-label">{{
        $options.setting.info_sort_description_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_sort_description"
          rules="required|max:500"
          v-slot="{ errors }"
        >
          <textarea
            id="input-info-sort-description"
            v-model="generalData.sort_description"
            class="form-control"
            :placeholder="$options.setting.info_sort_description_txt"
          ></textarea>

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group required">
      <label for="input-info-description" class="col-sm-2 control-label">{{
        $options.setting.info_description_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_sort_description"
          rules="required"
          v-slot="{ errors }"
        >
          <tinymce
            id="input-info-description"
            :other_options="options"
            v-model="generalData.description"
          ></tinymce>

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group required">
      <label for="input-info-meta-title" class="col-sm-2 control-label">{{
        $options.setting.info_meta_title_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_title"
          rules="required|max:255"
          v-slot="{ errors }"
        >
          <input
            id="input-info-meta-title"
            v-model="generalData.meta_title"
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
            v-model="generalData.meta_description"
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
            v-model="generalData.meta_keyword"
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
            v-model="generalData.tag"
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
import tinymce from 'vue-tinymce-editor'
import { fnCheckImgPath, } from '@app/common/util'
import { config, } from '@app/common/config'

export default {
  name: 'TabGeneralFormGiaoPhanTinTuc',
  components: {
    tinymce,
  },
  props: {
    generalData: {
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
  watch: {
    generalData: {
      immediate: true,
      deep: true,
      handler(newValue) {
        if (Object.keys(newValue).length) {
          return (newValue.context =
            newValue.context === null ? '' : newValue.context)
        }
      },
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
