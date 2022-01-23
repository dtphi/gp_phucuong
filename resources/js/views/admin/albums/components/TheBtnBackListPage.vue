<template>
    <a
        :href="_getHref()"
        data-toggle="tooltip"
        title="Trở về"
        class="btn btn-default">
        <i class="fa fa-reply"></i>
    </a>
</template>

<script>
import {
  config,
} from '@app/common/config'

export default {
  name: 'TheBtnBackListPage',
  props: {},
  methods: {
    _getHref() {
      return `${this.$cmsCfg.baseUrl}/${config.adminPrefix}/albums`
    },
  },
}
</script>
