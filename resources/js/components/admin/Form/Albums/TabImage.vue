<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <div id="media-info-manager"></div>
      </div>
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left">{{ $options.setting.image_main_txt }}</td>
                <td>{{ $options.setting.image_main_path_txt }}</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-left">
                  <div class="file animated fadeIn" style="height: 61px">
                    <div class="file-preview">
                      <img :src="_getImgUrl()" class="thumb" />
                    </div>
                  </div>
                </td>
                <td>
                  <input
                    type="text"
                    class="form-control"
                    id="file-input"
                    :value="_getImgUrl()"
                    disabled
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
require('@app/tools/mm/dist/style.css')
import { MM, } from '@app/tools/mm/dist/mm.min'
import { EmitOnSelectedImage, } from '@app/api/utils/event-bus'
import { fnCheckImgSelect, } from '@app/common/util'

export default {
  name: 'TabImageForm',
  components: {},
  props: {
    groupData: {
      type: Object,
    },
  },
  data() {
    return {
      mediaMM: null,
    }
  },
  computed: {
    _isShowImgThumb() {
      return this._isEditForm()
    },
  },
  mounted() {
    this.mediaMM = new MM({
      el: '#media-info-manager',
      api: this.$cmsCfg.mm.api,
      input: {
        el: '#file-input',
        multiple: false,
      },
      onSelect: (event) => {
        this._changeImage(event)
      },
    })
  },
  methods: {
    _changeImage(fi) {
      fnCheckImgSelect(fi) ? EmitOnSelectedImage(fi): ''
    },
    _getImgUrl() {
      const thumb = this.groupData?.image?.thumb
      
      return (typeof thumb !== 'string') ? this.$helper.fn_img_base_url(): thumb
    },
    _isEditForm() {
      return Object.keys(this.groupData).length
        ? this.groupData.id
          ? true
          : false
        : false
    },
  },
  setting: {
    image_main_txt: 'Hình ảnh',
    image_main_path_txt: 'Tên tập tin',
  },
}
</script>
