<template>
  <div>
    <div class="form-group">
      <info-media-manage
        :selected-image="_changeAlbumsImage"
      ></info-media-manage>

      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left">{{ $options.setting.image_title }}</td>
                <td>Sắp xếp</td>
                <td>Height</td>
                <td>Trạng thái</td>
                <td>Mở</td>
                <td>Thực hiện</td>
              </tr>
            </thead>
            <tbody v-if="_getBannerList.length">
              <item-image
                v-for="(item, idx) in _getBannerList"
                :key="idx"
                :banner="item"
              ></item-image>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, } from 'vuex'
import { MODULE_MODULE_ALBUMS_ADD, } from 'store@admin/types/module-types'
import ItemImage from './ItemImage'
import InfoMediaManage from '../Images/InfoImage'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'TheInfoListAlbumsImage',
  components: {
    ItemImage,
    InfoMediaManage,
  },
  computed: {
    ...mapGetters(MODULE_MODULE_ALBUMS_ADD, ['infoAlbumsImage']),
    _getBannerList() {
      return this.infoAlbumsImage.value
    },
  },
  methods: {
    _changeAlbumsImage(fi) {
      const _self = this
      if (typeof fi === 'object') {
        if (fnCheckProp(fi, 'selected') && fi.selected) {
          if (fnCheckProp(fi.selected, 'path')) {
            _self.$emit('select-multiple-banner-img', {
              filePath: fi.selected.path,
            })
          }
        }
      }
    },
  },
  setting: {
    image_title: 'Hình ảnh',
    image_url_title: 'Url hình',
  },
}
</script>
