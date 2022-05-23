<template>
  <figcaption class="figure-caption">
    <h4 class="title mt-2 ellipsis-two-lines">
      <a :href="_getHref()">{{ info.ten_le }} ( Ngày {{ info.solar_day }} Tháng {{ info.solar_month }})</a>
    </h4>
    <!-- <span class="d-block view-date"
      >{{ info.solar_day }}-{{ info.solar_month }}</span
    > -->
    <span class="d-block mb-1">
      <div class="ellipsis-three-lines" v-html="info.hanh"></div>
    </span>
    <span class="d-block mb-1"></span>
  </figcaption>
</template>

<script>
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'

export default {
  name: 'TheCategoryNewsItem',
  props: {
    info: {},
  },
  data() {
    return {
      year: new Date().getFullYear(),
    }
  },
  methods: {
    _getHref() {
      if ((String(this.info['slug']) !== 'undefined') && (String(this.info['slug']).length > 5)) {
        return fn_get_href_base_url(`/hanh-cac-thanh/chi-tiet/${this.info.slug}-${this.info.id}`)
      } else {
        return fn_get_href_base_url(`/hanh-cac-thanh/chi-tiet/${fn_change_to_slug(this.info.slug)}`)
      }
    },
  },
}
</script>
