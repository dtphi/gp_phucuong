<template>
  <figure>
    <a class="img-video" :href="_getHref()">
      <img v-lazy="info.imgThumUrl" class="rounded img" :alt="_getHref()" />
    </a>
    <video-caption
      v-if="info.information_type == 2"
      key="video-info-item"
      :info="info"
    ></video-caption>
    <news-caption v-else key="news-info-item" :info="info"></news-caption>
  </figure>
</template>

<script>
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'
import VideoCaption from './TheVideoItemCaption'
import NewsCaption from './TheNewsItemCaption'

export default {
  name: 'TheCategoryNewsItem',
  components: { VideoCaption, NewsCaption, },
  props: {
    info: {},
  },
  data() {
    return {}
  },
  methods: {
    _getHref() {
      if (this.info.hasOwnProperty('name_slug')) {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${this.info.name_slug}`)
      } else {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${fn_change_to_slug(this.info.name)}`)
      }
    },
  },
}
</script>
