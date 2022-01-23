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

export default {
  name: 'TheBtnBackListPageGiaoPhanTinTuc',
  props: {},
  methods: {
    _getHref() {
      return `${this.$cmsCfg.baseUrl}/${this.$cmsCfg.adminPrefix}/giao-phan/tin-tucs`
    },
  },
}
</script>
