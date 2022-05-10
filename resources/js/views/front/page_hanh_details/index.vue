<template>
  <main id="news" class="py-2">
    <div class="container">
      <main-menu></main-menu>
      <div
        style="background-color: #80808008"
        :style="{ backgroundColor: contentBgColor }"
      >
        <content-top v-if="_isContentTop">
          <template v-if="loading">
            <loading-over-lay
              :active.sync="loading"
              :is-full-page="fullPage"
            ></loading-over-lay>
          </template>
          <info-data-detail></info-data-detail>
          <!-- <template #column_right>
            <social-network></social-network>
            <div class="box-social">
              <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
            </div>
          </template> -->
        </content-top>
        <!-- <main-content v-if="_isContentMain"></main-content> -->
        <!-- <the-related-info></the-related-info> -->
        <!-- <module-co-the-ban-quan-tam></module-co-the-ban-quan-tam> -->
        <!-- <content-bottom v-if="_isContentBottom"></content-bottom> -->
      </div>
    </div>
  </main>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import ImgFooter from 'v@front/assets/img/image_footer.jpg'
import MainMenu from 'com@front/Common/MainMenu'
import { MODULE_HANH_CAC_THANH_DETAIL, } from '@app/stores/front/types/module-types'
import { GET_DETAIL, } from '@app/stores/front/types/action-types'
import ContentTop from 'com@front/Common/ContentTop'
import MainContent from 'com@front/Common/MainContent'
import ContentBottom from 'com@front/Common/ContentBottom'
import InfoDataDetail from 'com@front/Common/hanhDetail'
import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular'
import SocialNetwork from 'com@front/Common/SocialNetwork'
import TheRelatedInfo from './components/TheRelatedInfo'
import ModuleCoTheBanQuanTam from 'v@front/modules/co_the_ban_quan_tams'
export default {
  name: 'NewsDetailPage',
  components: {
    MainMenu,
    ContentTop,
    MainContent,
    ContentBottom,
    InfoDataDetail,
    TabInfoViewedAndPopular,
    SocialNetwork,
    TheRelatedInfo,
    ModuleCoTheBanQuanTam,
  },
  data() {
    return {
      imgFooter: ImgFooter,
      fullPage: false,
    }
  },
  computed: {
    ...mapState({
      contentBgColor: (state) => state.cfApp.setting.contentBgColor,
    }),
    ...mapState(MODULE_HANH_CAC_THANH_DETAIL, {
      loading: (state) => state.loading,
      pageLists: (state) => state.pageLists,
    }),
    ...mapGetters(MODULE_HANH_CAC_THANH_DETAIL, ['pageLists']),
    _isContentTop() {
      return this.$route.meta.layout_content.content_top
    },
    _isContentBottom() {
      return this.$route.meta.layout_content.content_bottom
    },
    _isContentMain() {
      return this.$route.meta.layout_content.content_main
    },
  },
  mounted() {
    this.getDetail({
      slug: this.$route.params.slug,
    })
  },
  methods: {
    ...mapActions(MODULE_HANH_CAC_THANH_DETAIL, {
      getDetail: GET_DETAIL,
    }),
  },
}
</script>

<style lang="scss">
@import "./new-detail-styles.scss";
</style>