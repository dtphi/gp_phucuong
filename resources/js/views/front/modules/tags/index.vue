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
            v-for="tag in _tags"
            :key="tag"
            :id="`my-custom-tags-tag_${tag.replace(/\s/g, '_')}_`"
            tag="li"
            class="mt-1 mr-1"
            body-class="py-1 text-nowrap"
          >
            <a href="javascript:void(0)">{{ tag }}</a>
          </b-card>
        </ul>
      </b-form-tags>
    </div>
  </b-col>
</div>
</template>

<script>
import { mapState, mapGetters, } from 'vuex'
import { MODULE_MODULE_VAN_KIEN, } from 'store@front/types/module-types'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'

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
    ...mapGetters(MODULE_MODULE_VAN_KIEN, ['settingCategory', 'pageLists']),
    _tags() {
      let tags = []
      _.cloneDeep(this.infoLasteds).forEach(element => {
        if (element?.tag?.length) {
          tags = tags.concat(element.tag)
        }
        tags = [...new Set(tags)]
      });
      return  tags
    },
  },
  methods: {
    _getHref(info) {
      if ((String(info['name_slug']) !== 'undefined') && (String(info['name_slug']).length > 5)) {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${info.name_slug}`)
      } else {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${fn_change_to_slug(info.name)}`)
      }
    },
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>