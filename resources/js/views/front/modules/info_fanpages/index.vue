<template>
  <div class="fanpage mt-4">
    <h4 class="tit-common clr-orange">fanpage</h4>
    <div
      class="fb-page fb_iframe_widget"
      data-href="https://www.facebook.com/truyenthongphucuong/"
      data-tabs="timeline, messages"
      data-small-header="true"
      data-adapt-container-width="true"
      data-hide-cover="false"
      data-show-facepile="true"
      fb-xfbml-state="rendered"
    >
      <iframe
        width="350px"
        height="500px"
        data-testid="fb:page Facebook Social Plugin"
        title="fb:page Facebook Social Plugin"
        frameborder="0"
        allowtransparency="true"
        allowfullscreen="true"
        scrolling="no"
        allow="encrypted-media"
        src="https://www.facebook.com/v5.0/plugins/page.php?adapt_container_width=true&amp;app_id=210446675691863&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df2eb147e0af6c64%26domain%3Dgiaophanphucuong.org%26origin%3Dhttps%253A%252F%252Fgiaophanphucuong.org%252Ff46cb85af4ed18%26relation%3Dparent.parent&amp;container_width=330&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Ftruyenthongphucuong%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=true&amp;tabs=timeline%2C%20messages&amp;width=330"
      ></iframe>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_THONG_BAO, } from 'store@front/types/module-types'

export default {
  name: 'ModuleFanpageInfo',
  components: {},
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapGetters(MODULE_MODULE_THONG_BAO, ['settingCategory']),
    _isExist() {
      return this.settingCategory.length
    },
  },
}
</script>
