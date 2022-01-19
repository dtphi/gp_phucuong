<template>
  <a
    :href="_getHref()"
    data-toggle="tooltip"
    title="Trở về"
    class="btn btn-default"
  >
    <i class="fa fa-reply"></i>
  </a>
</template>

<script>
import { fn_get_base_url, } from '@app/api/utils/fn-helper'
import { config, } from '@app/common/config'

export default {
  name: 'TheBtnBackListPageGiaoPhanTinTuc',
  props: {},
  methods: {
    _getHref() {
      return fn_get_base_url() + `/${config.adminPrefix}/giao-phan/tin-tucs`
    },
  },
}
</script>
