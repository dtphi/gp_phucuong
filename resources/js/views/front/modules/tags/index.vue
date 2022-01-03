<template>
<div class="row mt-2">
  <b-col cols="8" class="col-mobile">
    <div id="tags-module" class="mt-4 new-document" v-if="_tags.length">
      <h4 class="tit-common mb-3">
        <b-icon icon="tag-fill"></b-icon>Tags
      </h4>
      <b-form-tags no-outer-focus class="mb-2 cms-form-control">
        <ul
          id="my-custom-tags-list"
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
  </b-col>
</div>
</template>

<script>
import { mapState, } from 'vuex'
import {
  fn_get_href_base_url,
} from '@app/api/utils/fn-helper'
import { config, } from '@app/common/config'

export default {
  name: 'ModuleTag',
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapState({
      infoLasteds: state => state.cfApp.setting.infoLasteds,
    }),
    _tags() {
      let tags = []
      _.cloneDeep(this.infoLasteds).forEach(element => {
        if (element?.tag?.length) {
          const mapObjs = _.map(element.tag, function(item) {
            item = {
              'href': fn_get_href_base_url(`tin-tuc/chi-tiet/${element.name_slug}`),
              'name': item
            }
            return item
          })
          if (tags.length > config.tagLimit) {
            return tags
          }
          tags = tags.concat(mapObjs)
        }
        // create unique array
        //tags = [...new Set(tags)]
      });
      return  tags
    },
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>