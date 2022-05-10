<template>
  <div class="new-detail">
    <h4 class="tit-detail">{{ pageLists.ten_le }}</h4>
    <p>
      <b-icon class="alarm" icon="alarm"></b-icon>
      <span>{{ pageLists.solar_day }}-{{pageLists.solar_month}}</span>
    </p>

    <p v-html="pageLists.hanh"></p>

    <hr />
  </div>
</template>

<script>
import { mapGetters, mapState} from 'vuex'
import ImgFooter from 'v@front/assets/img/image_footer.jpg'
import InfoTag from 'com@front/Common/InfoTag'
import { MODULE_HANH_CAC_THANH_DETAIL, } from '@app/stores/front/types/module-types'
import 'viewerjs/dist/viewer.css'
import Viewer from 'viewerjs'

export default {
  name: 'ContentLeft',
  components: { InfoTag },
  data() {
    return {
      imgFooter: ImgFooter,
      viewer: false,
    }
  },
  computed: {
    ...mapState(MODULE_HANH_CAC_THANH_DETAIL, {
      loading: (state) => state.loading,
      pageLists: (state) => state.pageLists,
    }),
  },
  methods: {
    _showSlide() {
      if (this.viewer) {
        return
      }
      new Viewer(document.getElementById('images'), {
        url: 'data-original',
      })
      this.viewer = true
    },
  },
}
</script>

<style>
.docs-pictures {
  list-style: none;
  margin: 0;
  padding: 0;
}
.docs-pictures > li {
  border: 1px solid transparent;
  float: left;
  height: calc(100% / 4);
  margin: 0 -1px -1px 0;
  overflow: hidden;
  width: calc(100% / 4);
}
.docs-pictures > li > img {
  cursor: -webkit-zoom-in;
  cursor: zoom-in;
  width: 100%;
}
.viewer-backdrop {
  background-color: rgba(0, 0, 0, 0.75) !important;
}
</style>
