<template>
  <div id="lich-cong-giao-module" class="calendar mt-4">
    <h4 class="title"><span>Lịch</span></h4>
    <b-calendar class="w-100" locale="vi-VN"></b-calendar>
  </div>
</template>

<script>

export default {
  name: 'ModuleLichCongGiao',
  components: {},
  data() {
    return {
      fullPage: true,
    }
  },
  methods: {},
  setting: {
    panel_title: 'Module Danh Mục Icon',
    frm_title: 'Thêm danh mục Icon',
    btn_save_txt: 'Lưu',
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>