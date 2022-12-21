<template>
  <div class="new-detail">
    <h1 class="tit-detail">{{ pageLists.name }}</h1>
    <p>
      <b-icon class="alarm" icon="alarm"></b-icon>
      <span>{{ pageLists.date_available }}</span>
    </p>

    <p v-html="pageLists.sort_description"></p>

    <hr />

    <div class="text-detail" v-html="pageLists.description"></div>

    <hr />
  </div>
</template>

<script>
import { mapGetters, } from 'vuex'
import ImgFooter from 'v@front/assets/img/image_footer.jpg'
import { MODULE_VIDEO_DETAIL, } from '@app/stores/front/types/module-types'

export default {
  name: 'ContentLeft',
  components: {},
  data() {
    return {
      imgFooter: ImgFooter,
    }
  },
  computed: {
    ...mapGetters(MODULE_VIDEO_DETAIL, ['pageLists']),
  },
}
</script>

<style lang="scss">
@media screen and (max-width: 767px) {
  .new-detail {
    .text-detail {
      iframe {
        width: 100% !important;
      }
    }
  }
}
</style>
