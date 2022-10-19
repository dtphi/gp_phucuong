<template>
  <b-tab class="tab-bar" title="Tác giả">
    <a
      :href="_getHref(item.id,item.name)"
      class="row-item-3 d-block mb-2 pb-2"
      v-for="(item, idx) in listtacgia"
      :key="idx"
    >
    <span hidden>
        </span>
    <span>✍<i>{{ item.name}}</i></span
      >
    </a>
  </b-tab>
</template>

<script>
import { mapState, } from 'vuex'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'TabInfoAuthor',
  data() {
    return {
      listtacgia:[],
    }
  },
  computed: {
    ...mapState({
      infoList: (state) => state.cfApp.setting.infoPopulars,
    }),
  },
  mounted(){
    this._getListTacgia()
  },
  methods: {
    _getHref(id,name) {
        return fn_get_href_base_url(
          'tin-tuc/tags/'+name+'?tacgias=' + (id)
        )
      
    },
    _getListTacgia(){
      var self=this
      var url=fn_get_base_api_url('/api/informations/getlisttacgias')
      $.getJSON(url, function(json) {
        if (json){
          self.listtacgia=json
        }
      });
    }
  },
}
</script>

<style lang="scss"></style>
