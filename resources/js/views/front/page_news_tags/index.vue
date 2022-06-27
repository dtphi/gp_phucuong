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
            <!-- <the-list-category-news-item
              class="info-list"
              v-for="(item, idx) in infoList"
              :info="item"
              :key="idx"
            ></the-list-category-news-item> -->
            <a style="text-decoration: none" target="blank" :href="infoTag.link_chi_tiet">
              <h3>{{infoTag.name}}</h3>
              <img style="width: 100%" v-if="infoTag.image" :src="infoTag.image.path" alt="123">
              <p class="mt-1">{{infoTag.sort_description}}</p>
            </a>

            <!-- <template v-if="infoList.length == 0">
              <div
                style="text-align: center; font-size: 30px; color: #f0f8ffc7"
              >

              </div>
            </template> -->
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
import { mapActions, mapState, } from 'vuex'
import MainMenu from 'com@front/Common/MainMenu'
import TheListCategoryNewsItem from './components/TheListCategoryNewsItem'
import Paginate from 'com@front/Pagination'
import { MODULE_INFO, MODULE_INFO_DETAIL} from '@app/stores/front/types/module-types'
import { GET_INFORMATION_LIST_TO_CATEGORY, } from '@app/stores/front/types/action-types'
import MainContent from 'com@front/Common/MainContent'
import ContentBottom from 'com@front/Common/ContentBottom'
import ContentTop from 'com@front/Common/ContentTop'
import SocialNetwork from 'com@front/Common/SocialNetwork'

export default {
  name: 'InfoListtoCategory',
  components: {
    MainMenu,
    ContentTop,
    MainContent,
    ContentBottom,
    TheListCategoryNewsItem,
    Paginate,
    SocialNetwork,
  },
  data() {
    return {
      fullPage: false,
      isResource: false,
    }
  },
  computed: {
    ...mapState({
      contentBgColor: state => state.cfApp.setting.contentBgColor,
    }),
    // ...mapState(MODULE_INFO, {
    //   infoList: state => state.pageLists,
    //   loading: state => state.loading,
    // }),
    ...mapState(MODULE_INFO_DETAIL, {
      loading: (state) => state.loading,
      infoTag: (state) => state.infoTag,
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
    // this.getInfoListToCategory({
    //   ...this.$route.params,
    //   news_group_type: 'tag_type',
    // })
    this.getInfoTag({
      slug: this.$route.params.slug,
    })
  },
  methods: {
    // ...mapActions(MODULE_INFO, {
    //   getInfoListToCategory: GET_INFORMATION_LIST_TO_CATEGORY,
    // }),
    ...mapActions(MODULE_INFO_DETAIL, {
      getInfoTag: 'GET_INFO_TAG',
    }),

  },
}
</script>

<style lang="scss">
@import "./category-news-styles.scss";
</style>
