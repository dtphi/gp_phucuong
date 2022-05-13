<template>
  <main id="video" class="py-2">
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
          <div class="list-videos">
            <the-list-category-news-item
              class="info-list"
              v-for="(item, idx) in infoList"
              :info="item"
              :key="idx"
            ></the-list-category-news-item>
          </div>
          <paginate></paginate>
          <template #column_right>
            <social-network></social-network>
            <div class="box-care mt-3">
              <b-row class="mt-3">
                <b-col cols="12" class="m-auto">
                  <p class="mb-0 text-download">Tải app sách nói công giáo</p>
                </b-col>
                <b-col cols="12">
                  <b-carousel
                    id="carousel-2"
                    :interval="4000"
                    controls
                    indicators
                  >
                    <b-carousel-slide
                      img-src="https://picsum.photos/1024/480/?image=58"
                    ></b-carousel-slide>
                    <b-carousel-slide
                      img-src="https://picsum.photos/1024/480/?image=58"
                    ></b-carousel-slide>
                  </b-carousel>
                </b-col>
              </b-row>
            </div>
          </template>
        </content-top>
        <main-content v-if="_isContentMain"></main-content>
        <content-bottom v-if="_isContentBottom"></content-bottom>
      </div>
    </div>
  </main>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import MainMenu from 'com@front/Common/MainMenu'
import TheListCategoryNewsItem from './components/TheListCategoryNewsItem'
import Paginate from 'com@front/Pagination'
import { MODULE_HANH_CAC_THANH } from '@app/stores/front/types/module-types'
import { GET_LISTS } from '@app/stores/front/types/action-types'
import MainContent from 'com@front/Common/MainContent'
import ContentBottom from 'com@front/Common/ContentBottom'
import ContentTop from 'com@front/Common/ContentTop'
import SocialNetwork from 'com@front/Common/SocialNetwork'

export default {
  name: 'InfoListtoHanh',
  components: {
    MainMenu,
    ContentTop,
    MainContent,
    ContentBottom,
    Paginate,
    SocialNetwork,
    TheListCategoryNewsItem,
  },
  data() {
    return {
      fullPage: false,
      isResource: false,
    }
  },
  computed: {
    ...mapState({
      contentBgColor: (state) => state.cfApp.setting.contentBgColor,
    }),
    ...mapState(MODULE_HANH_CAC_THANH, {
      infoList: (state) => state.pageLists,
      loading: (state) => state.loading,
    }),
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
    this.getInfoListToHanh({
      ...this.$route.params,
      renderType: 1,
    })
  },
  methods: {
    ...mapActions(MODULE_HANH_CAC_THANH, {
      getInfoListToHanh: GET_LISTS,
    }),
  },
}
</script>

<style lang="scss">
@import "./category-news-styles.scss";
</style>