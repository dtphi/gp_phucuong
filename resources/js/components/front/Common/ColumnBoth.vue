<template>
  <div id="content-column-both">
    <keep-alive v-for="(item, idx) in _moduleList" :key="idx">
      <component v-bind:is="item"></component>
    </keep-alive>
  </div>
</template>

<script>
import { mapState, } from 'vuex'
import noi_bats from 'v@front/modules/noi_bats'
import page_banner_lists from 'v@front/modules/page_banner_lists'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'ColumnBoth',
  components: {
    'module-noi-bat': noi_bats,
    'module-page-banner-list': page_banner_lists,
  },
  props: {
    contentType: {
      default: 'top',
    },
  },
  data() {
    return {}
  },
  computed: {
    ...mapState({
      setting: (state) => state.cfApp.setting,
    }),
    _moduleList() {
      let list = []

      if (Object.keys(this.setting) && fnCheckProp(this.setting, 'modules')) {
        let contentType = 'content_' + this.contentType + '_column'
        let modules = this.$route.meta.layout_content[contentType].both_modules
        if (modules && modules.length) {
          _.forEach(modules, function(item) {
            list.push('module-' + item.moduleName.toLowerCase())
          })
        }
      }

      return list
    },
  },
}
</script>
