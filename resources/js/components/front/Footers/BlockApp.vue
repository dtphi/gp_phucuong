<template>
  <div class="row mb-3 pb-3 row-item-app">
    <div class="col-4 col-img pl-0">
      <img class="img" :src="_getImgUrl()" alt="Hình ảnh Phú Cường" />
    </div>
    <div class="col-8 col-detail pl-0">
      <h4 class="tit-app-ft mt-2">{{ appItem.title }}</h4>
      <a
        class="link-app d-block mb-2"
        :href="appItem.hrefAppStore"
        target="_blank"
        >- Download từ Apple Store</a
      >
      <a class="link-app d-block" :href="appItem.hrefChPlay" target="_blank"
        >- Download từ CH Play</a
      >
    </div>
  </div>
</template>

<script>

export default {
  name: 'BlockAppFooter',
  components: {},
  props: {
    appItem: {},
  },
  data() {
    return {
      imageAppDefault: '',
    }
  },
  methods: {
    _getImgUrl() {
      return this.$cmsCfg.baseUrl + this.appItem.img
    },
  },
}
</script>
