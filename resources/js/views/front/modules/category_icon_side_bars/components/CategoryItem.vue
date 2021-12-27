<template>
  <b-col cols="4">
    <a
     class="d-block mb-4"
     :class="_getColor()"
     :href="_getHref()">{{ _getTitle() }}
    </a>
  </b-col>
</template>

<script>
import { fn_get_href_base_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'NavigationIconItem',
  props: {
    idx: {
      type: [Number, String],
      default() {
        return 0
      },
    },
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
  data() {
    return {
      iconItemColor: [
        'blue',
        'red',
        'orange',
        'green',
        'pink',
        'grow',
        'blue',
        'red',
        'orange',
        'green',
        'pink',
        'grow'
      ],
    }
  },
  methods: {
    _getColor() {
      const color = this.iconItemColor[this.idx]
      
      return `bg-${color}`
    },
    _getTitle() {
      if (this.title) {
        return this.title
      }
      
      return this.group.name
    },
    _getHref() {
      if (this.link) {
        return fn_get_href_base_url(this.link)
      }
      
      return fn_get_href_base_url(`danh-muc-tin/${this.group.link}`)
    },
  },
}
</script>
