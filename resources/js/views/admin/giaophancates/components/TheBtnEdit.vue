<template>
  <a
    href="javascript:void(0);"
    @click="_redirectUrl()"
    data-toggle="tooltip"
    title=""
    class="btn btn-default cms-btn"
    data-original-title="Edit"
  >
    <font-awesome-layers style="background: honeydew">
      <font-awesome-icon size="1x" icon="edit" />
    </font-awesome-layers>
  </a>
</template>

<script>
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonEdit',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
    categoryId: {
      type: Number,
      default: 0,
      validator: function(value) {
        return value && Number.isInteger(value)
      },
    },
  },
  methods: {
    _pushEditPage() {
      this.$router.push(
        `/${this.$cmsCfg.adminPrefix}/giao-phan/danh-mucs/edit/${this.categoryId}`
      )
    },
    _redirectUrl() {
      return fn_redirect_url(
        `${this.$cmsCfg.adminPrefix}/giao-phan/danh-mucs/edit/${this.categoryId}`
      )
    },
    _getHref() {
      return (`${this.$cmsCfg.baseUrl}/${this.$cmsCfg.adminPrefix}/giao-phan/danh-mucs/edit/${this.categoryId}`)
    },
  },
}
</script>
