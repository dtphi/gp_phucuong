<template>
  <figure>
    <a class="img-video" :href="_getHref()">
      <img :src="info.imgThumUrl" class="rounded img" :alt="_getHref()" />
    </a>
    <figcaption class="figure-caption">
      <h2 class="title mt-2">
        <img :src="iconBook" alt="Icon" />
        <a :href="_getHref()">{{ info.sort_name }}...</a>
      </h2>
      <span class="d-block mb-1">
        <div v-html="info.sort_description"></div>
        <a :href="_getHref()">...</a></span
      >
      <span class="d-block mb-1"></span>
      <span class="d-block"
        >{{ info.viewed }} lượt xem | {{ info.date_available }}</span
      >
    </figcaption>
  </figure>
</template>

<script>
import { mapGetters, } from 'vuex'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'
import IconBook from 'v@front/assets/img/icon-book.png'

export default {
  name: 'TheCategoryNewsItem',
  props: {
    info: {},
  },
  components: {},
  data() {
    return {
      iconBook: IconBook,
    }
  },
  computed: {
    ...mapGetters(['iconBookUrl']),
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
