<template>
  <div class="list-item-category">
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
}
</script>

<style lang="scss">
.list-item-category {
  margin-bottom: 15px;
  padding-bottom: 15px;
  border-bottom: 1px solid;

  .figure-caption {
    .title {
      a {
        font-size: 16px;
        font-weight: bold;
      }
    }

    .view-date {
      font-style: italic;
      font-weight: 600;
      margin-bottom: 5px;
    }
  }
}
</style>