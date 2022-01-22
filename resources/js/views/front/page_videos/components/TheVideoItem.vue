<template>
  <figure>
    <a class="img-video" :href="_getHref()">
      <img :src="info.imgThumUrl" class="rounded img" :alt="_getHref()" />
    </a>
    <figcaption class="figure-caption">
      <h4 class="title mt-2">
        <img :src="iconBook" alt="Icon" />
        <a :href="_getHref()">{{ info.name }}</a>
      </h4>
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
  name: 'TheVideoItem',
  props: {
    info: {},
  },
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
        return fn_get_href_base_url(`video/chi-tiet/${this.info.name_slug}`)
      } else {
        return fn_get_href_base_url(`video/chi-tiet/${fn_change_to_slug(this.info.name)}`)
      }
    },
  },
}
</script>
