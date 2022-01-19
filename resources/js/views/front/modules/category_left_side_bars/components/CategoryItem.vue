<template>
  <li :class="_getActiveClass">
    <a @click="_getHref()">≫ {{ _getTitle() }}</a>
  </li>
</template>

<script>
import { mapActions, mapGetters, mapState, } from 'vuex'
import { MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, } from '@app/stores/front/types/module-types'

export default {
  name: 'NavigationMainItem',
  props: {
    title: {
      type: String,
      default() {
        return ''
      },
    },
    link: {
      type: String,
      default() {
        return ''
      },
    },
    activeClass: {
      type: String,
      default() {
        return ''
      },
    },
    group: {
      type: [Object, Array],
      default() {
        return {}
      },
    },
  },
  computed: {
    ...mapGetters(['moduleNameActive', 'moduleActionListActive']),
    ...mapState(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, ['linkActive']),
    _getActiveClass() {
      if (this.group.link == this.linkActive) {
        return 'active'
      }
      
      return ''
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, ['setActiveLink']),
    _getTitle() {
      if (this.title) {
        return this.title
      }
      
      return this.group.name
    },
    _getHref() {
      const actionName = `${this.moduleNameActive}/GET_INFORMATION_LIST_TO_LEFT_CATEGORY`
      this.$store.dispatch(actionName, {
        ...this.$route.params,
        slug: this.group.link,
        moduleName: 'category_left_side_bar',
        renderType: 1,
      })
      this.setActiveLink(this.group.link)
    },
  },
}
</script>
