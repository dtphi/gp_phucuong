<template>
  <b-carousel
    id="carousel-1"
    :interval="4000"
    controls
    style="cursor: pointer"
    indicators
  >
    <b-carousel-slide v-for="(item, index) in _getInfoCarousel" :key="index">
      <template v-slot:img>
        <img
          @click="_redirectUrl(item)"
          class="d-block img-fluid w-100"
          width="730"
          height="410"
          :src="item.imgCarThumUrl"
        />
      </template>
      <div v-if="_getSettingFormat == 3" class="description text-left">
        <p class="text-right mb-0">{{ item.date_available }}</p>
      </div>
      <div v-if="_getSettingFormat == 2" class="description text-left">
        <p class="mb-2">
          {{ item.sort_description }}
          <a :href="_getHref(item)" class="ml-2"><b>Xem thêm</b></a>
        </p>
        <p class="text-right mb-0">{{ item.date_available }}</p>
      </div>
      <div v-if="_getSettingFormat == 1" class="description text-left">
        <h6>{{ item.name }}</h6>
        <p class="mb-2">
          {{ item.sort_description }}
          <a :href="_getHref(item)" class="ml-2"><b>Xem thêm</b></a>
        </p>
        <p class="text-right mb-0">{{ item.date_available }}</p>
      </div>
    </b-carousel-slide>
  </b-carousel>
</template>

<script>
import { mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_SPECIAL_INFO, } from 'store@front/types/module-types'
import { ACTION_GET_SETTING, } from 'store@front/types/action-types'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'

export default {
  name: 'ModuleCarouselSpecialInfo',
  components: {},
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapGetters(['isScreen414', 'isScreen767']),
    ...mapGetters(MODULE_MODULE_SPECIAL_INFO, ['pageLists']),
    _getInfoCarousel() {
      if (this.pageLists.length) {
        let infos = this.pageLists
        var asorts = _.orderBy(infos,(o) => o.id, 'desc')
        let values = []
        _.forEach(asorts,(item, idx) => {
          if (idx < 5) {
            values.push(item)
          } else {
            return 0
          }
        });
        return values
      }
    },
    _getSettingFormat() {
      let des = 1
      if (this.isScreen767) {
        des = 2
      }
      if (this.isScreen414) {
        des = 3
      }
      return des
    },
  },
  created() {
    this.getSetting()
  },
  methods: {
    ...mapActions(MODULE_MODULE_SPECIAL_INFO, {
      getSetting: ACTION_GET_SETTING,
    }),
    _getHref(info) {
      if (info.hasOwnProperty('name_slug')) {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${info.name_slug}`)
      } else {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${fn_change_to_slug(info.name)}`)
      }
    },
    _redirectUrl(info) {
      window.location.href = this._getHref(info)
    },
  },
}
</script>
