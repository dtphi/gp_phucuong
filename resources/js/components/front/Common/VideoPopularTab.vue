<template>
  <b-tab class="tab-bar" title="Xem nhiều">
    <a
      :href="_getHref(item)"
      class="row-item-3 d-block mb-2 pb-2"
      v-for="(item, idx) in infoList"
      :key="idx"
    >
      <span>
        <i class="status bg-orange">Hot</i>
      </span>
      <span>
        <img :src="iconBook" alt="" />
        <i>{{ item.sort_name }}...</i>
      </span>
      <!--<span>
                <img :src="iconBook" alt="">
                <i>Thanh Thúy</i>
            </span>-->
    </a>
  </b-tab>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'

import { MODULE_INFO, } from '@app/stores/front/types/module-types'
import { GET_POPULAR_INFORMATION_LIST_TO_CATEGORY, } from '@app/stores/front/types/action-types'
import IconBook from 'v@front/assets/img/icon-book.png'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'TabInfoViewedAndPopular',
  components: {},
  data() {
    return {
      iconBook: IconBook,
    }
  },
  computed: {
    ...mapState(MODULE_INFO, {
      infoList: (state) => state.infoPopularList,
    }),
  },
  mounted() {
    this[GET_POPULAR_INFORMATION_LIST_TO_CATEGORY](this.$route.params)
  },
  methods: {
    ...mapActions(MODULE_INFO, [GET_POPULAR_INFORMATION_LIST_TO_CATEGORY]),
    _getHref(info) {
      if (fnCheckProp(info, 'name_slug')) {
        return fn_get_href_base_url('tin-tuc/chi-tiet/' + info.name_slug)
      } else {
        return fn_get_href_base_url(
          'tin-tuc/chi-tiet/' + fn_change_to_slug(info.name)
        )
      }
    },
  },
}
</script>

<style lang="scss"></style>
