<template>
  <button
    @click="_redirectUrl()"
    data-toggle="tooltip"
    title=""
    class="btn btn-primary"
    data-original-title="Thêm group albums"
  >
    <i class="fa fa-plus"></i>
  </button>
</template>

<script>
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonAddGroupAlbums',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    _redirectUrl() {
      return fn_redirect_url(`${this.$cmsCfg.adminPrefix}/group-albums/add`)
    },
  },
}
</script>
