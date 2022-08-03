<template>
  <div id="tags-module" class="mt-4 new-document" v-if="_tags.length">
    <h4 class="tit-common mb-3"><b-icon icon="tag-fill"></b-icon>Tags</h4>
    <b-form-tags no-outer-focus class="mb-2 cms-form-control">
      <ul
        id="my-custom-tags-list" style="width:100%; font-size:13px;"
        class="list-unstyled d-inline-flex flex-wrap mb-0"
        aria-live="polite"
        aria-atomic="false"
        aria-relevant="additions removals"
      >
        <b-card
          v-for="(tag, idx) in _tags"
          :key="idx"
          :id="`${idx}-tags-tag_${tag.name.replace(/\s/g, '_')}_`"
          tag="li"
          class="mt-1 mr-1"
          body-class="py-1 text-nowrap"
        >
          <a :href="tag.href">{{ tag.name }}</a>
        </b-card>
      </ul>
    </b-form-tags>
  </div>
</template>

<script>
import { fn_get_href_base_url } from '@app/api/utils/fn-helper'

export default {
  name: 'InfoTag',
  props: ['info'],
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    _tags() {
      let tags = []
      if (this.info?.tag?.length) {
        const mapObjs = _.map(this.info.tag, (item) => {
          console.log('element-common',this.info.tag)
          const splitStr = item.split('||');
          const objTag = {
            href: fn_get_href_base_url(
              `tin-tuc/tags/${this.$helper.slugify(item)}-${this.info.information_id}?tag=${splitStr[0]}`
            ),
            name: splitStr[1],
          }
          return objTag
        })
        tags = tags.concat(mapObjs)
      }
      return tags
    },
  },
}
</script>

<style lang="scss">
@import './styles.scss';
</style>
