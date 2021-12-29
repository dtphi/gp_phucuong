<template>
  <div>
    <div class="form-group">
      <info-media-manage
        :selected-image="_changeCarouselImage"
      ></info-media-manage>

      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left">{{ $options.setting.image_title }}</td>
                <td>Width</td>
                <td>Height</td>
                <td>Trạng thái</td>
                <td>Mở</td>
                <td>Thực hiện</td>
              </tr>
            </thead>
            <tbody v-if="_getBannerList.length">
              <item-carousel
                v-for="(item, idx) in _getBannerList"
                :key="idx"
                :banner="item"
              ></item-carousel>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, } from 'vuex'
import { MODULE_MODULE_SPECIAL_INFO_CAROUSEL, } from 'store@admin/types/module-types'
import ItemCarousel from './ItemCarousel'
import InfoMediaManage from '../Images/InfoImage'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'TheInfoListCarousel',
  components: {
    ItemCarousel,
    InfoMediaManage,
  },
  computed: {
    ...mapGetters(MODULE_MODULE_SPECIAL_INFO_CAROUSEL, ['specialInfoCarousel']),
    _getBannerList() {
      return this.specialInfoCarousel.value
    },
  },
  methods: {
    _changeCarouselImage(fi) {
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
    image_title: 'Banner',
    image_url_title: 'Url hình',
  },
}
</script>
