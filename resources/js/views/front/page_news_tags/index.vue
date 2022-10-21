<template>
  <main id="video" class="py-2">
    <div class="container">
      <main-menu></main-menu>
      <div
        style="background-color: #80808008"
        :style="{ backgroundColor: contentBgColor }"
      >
        <content-top v-if="_isContentTop">
          <template v-if="loading&&!isSearchTacgia">
            <loading-over-lay
              :active.sync="loading"
              :is-full-page="fullPage"
            ></loading-over-lay>
          </template>
          <div class="list-videos" v-if="!isSearchTacgia">
            <the-list-category-news-item
              class="info-list"
              v-for="(item, idx) in infoList"
              :info="item"
              :key="idx"
            ></the-list-category-news-item>
            <template v-if="infoList.length == 0">
              <div
                style="text-align: center; font-size: 30px; color: #f0f8ffc7"
              >
                ............
              </div>
            </template>
          </div>
          <div class="list-videos" v-else>
            <the-list-category-news-item
              class="info-list"
              v-for="(item, idx) in infoTacgiaList"
              :info="item"
              :key="idx"
            ></the-list-category-news-item>
            <template v-if="infoTacgiaList.length == 0">
              <div
                style="text-align: center; font-size: 30px; color: #f0f8ffc7"
              >
                ............
              </div>
            </template>
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
import { MODULE_INFO, } from '@app/stores/front/types/module-types'
import { GET_INFORMATION_LIST_TO_CATEGORY, } from '@app/stores/front/types/action-types'
import MainContent from 'com@front/Common/MainContent'
import ContentBottom from 'com@front/Common/ContentBottom'
import ContentTop from 'com@front/Common/ContentTop'
import SocialNetwork from 'com@front/Common/SocialNetwork'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
  fn_get_base_api_url,
} from '@app/api/utils/fn-helper'
var GLOBAL_URL=window.location.href.replace(/https?:\/\//,'')
var SP = GLOBAL_URL.split('=')
var tacgiaID=SP.at(-1)
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
      isSearchTacgia:false,
      infoTacgiaList:[],
    }
  },
  computed: {
    ...mapState({
      contentBgColor: state => state.cfApp.setting.contentBgColor,
    }),
    ...mapState(MODULE_INFO, {
      infoList: state => state.pageLists,
      loading: state => state.loading,
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
    this.getInfoListToCategory({
      ...this.$route.params,
      news_group_type: 'tag_type',
      tag: this.$route.query.tag,
    })
    this.isSearchTacgia=this._checkSearchTacgia()
    
  },
  methods: {
    ...mapActions(MODULE_INFO, {
      getInfoListToCategory: GET_INFORMATION_LIST_TO_CATEGORY,
    }),
    _checkSearchTacgia(){
      var self = this
      if (GLOBAL_URL.includes('?tacgias='))
      {
        var url =fn_get_href_base_url('/api/informations/getInfoTacgia?tacgia='+tacgiaID)
        
        $.getJSON(url, function(json) {
        self.infoTacgiaList=json
        //console.log(self.infoTacgiaList)
        });
        return true
      }
      else return false
    }
  },
}
</script>

<style lang="scss">
@import "./category-news-styles.scss";
</style>
