<template>
  <b-tab class="tab-bar" title="Bài mới" active>
    <b-card-text>
      <a
        :href="_getHref(item)"
        class="row-item-3 d-block mb-2 pb-2"
        v-for="(item, idx) in infoList"
        :key="idx"
      >
        <span>
          <i class="status bg-blue">Live</i>
        </span>
        <span
          >📄<i>{{ item.sort_name.substring(0, 40) }} …</i></span
        >
      </a>
    </b-card-text>
  </b-tab>
</template>

<script>
import { mapState, } from 'vuex'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'TabInfoLasted',
  data() {
    return {}
  },
  computed: {
    ...mapState({
      infoList: (state) => state.cfApp.setting.infoLasteds,
    }),
  },
  methods: {
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
