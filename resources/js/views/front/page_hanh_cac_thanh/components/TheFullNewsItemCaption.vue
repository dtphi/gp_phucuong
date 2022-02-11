<template>
  <figcaption class="figure-caption">
    <h4 class="title mt-2 ellipsis-two-lines">
      <a :href="_getHref()">{{ info.name }}</a>
    </h4>
    <span class="d-block view-date"
      >{{ info.viewed }} lượt xem | {{ info.date_available }}</span
    >
    <span class="d-block mb-1">
      <div class="ellipsis-three-lines" v-html="info.description"></div>
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
    return {}
  },
  methods: {
    _getHref() {
      if ((String(this.info['name_slug']) !== 'undefined') && (String(this.info['name_slug']).length > 5)) {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${this.info.name_slug}`)
      } else {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${fn_change_to_slug(this.info.name)}`)
      }
    },
  },
}
</script>

<style>

</style>