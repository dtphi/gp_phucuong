<template>
  <div class="list-item-category">
    <div v-if="info.isImgRender">
      <img style="width: 100%" :src="info.imgUrl" />
    </div>
    <full-news-caption :info="info"></full-news-caption>
  </div>
</template>

<script>
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'
import FullNewsCaption from './TheFullNewsItemCaption'

export default {
  name: 'TheCategoryNewsItem',
  components: {
    FullNewsCaption,
  },
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
