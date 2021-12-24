<template>
  <main id="news" class="py-2">
    <div class="container">
      <main-menu></main-menu>
      <div
        style="background-color: #80808008"
        :style="{ backgroundColor: contentBgColor }"
      >
        <content-top v-if="_isContentTop">
          <!-- Loading -->
          <!-- <template v-if="loading">
                <loading-over-lay
                    :active.sync="loading"
                    :is-full-page="fullPage"></loading-over-lay>
            </template> -->
          <template v-slot:column_right>
            <social-network></social-network>
            <div class="box-social">
              <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
            </div>
          </template>
        </content-top>
        <main-content v-if="_isContentMain">
          <!--<template v-slot:before_column_both>
                <div class="col-mobile col-12">
                    <module-page-banner-list></module-page-banner-list>
                </div>
            </template>-->
          <template v-slot:bottom>
            <div class="list-danh-muc w-100">
              <h2 class="title-linh-muc text-center">
                Danh sách giáo xứ giáo phận phú cường
                <hr class="line-linh-muc" />
              </h2>
              <div class="tab-linh-muc w-100">
                <b-tabs content-class="mt-3" fill>
                  <b-tab title="Tất cả" active>
                    <div class="list-giao-xu">
                      <div
                        v-for="(info, idx) in infoList"
                        :key="idx"
                        class="row row-linh-muc"
                      >
                        <div class="col-mobile col-2">
                          <a class="avatar" :href="info.hrefDetail">
                            <img
                              class="img"
                              v-lazy="info.image"
                              :alt="info.name"
                            />
                          </a>
                        </div>
                        <div class="col-mobile col-10 content">
                          <h4 class="tit">
                            <a :href="info.hrefDetail">
                              Giáo Xứ {{ info.name }}</a
                            >
                          </h4>
                          <div class="row">
                            <div class="col-6">
                              <span
                                >Giờ lễ: <span v-html="info.gio_le"></span
                              ></span>
                              <span>Địa chỉ: {{ info.dia_chi }}</span>
                              <span>Email: {{ info.email }}</span>
                            </div>
                            <div class="col-6">
                              <span>Điện thoại: {{ info.dien_thoai }}</span>
                              <span>Dân số: {{ info.dan_so }}</span>
                              <span>Số tín hữu: {{ info.so_tin_huu }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <paginate
                      :is-resource="isResource"
                      v-if="infoList"
                    ></paginate>
                  </b-tab>
                  <b-tab title="Lọc theo Giáo phận / Giáo hạt">
                    <div
                      class="col-mobile list-giao-xu"
                      style="margin-top: -30px"
                    >
                      <div
                        class="col-12 float-right bg-dark-gp"
                        style="margin-bottom: 15px"
                      >
                        <ul
                          class="
                            list-group list-group-horizontal-xl
                            float-right
                          "
                        >
                          <li
                            class="
                              list-group-item
                              bg-dark-gp
                              border-0
                              select-filter-gp
                            "
                          >
                            <model-select
                              :options="giaoPhanLists"
                              v-model="giaoPhan"
                              placeholder="Chọn Giáo Phận"
                            ></model-select>
                          </li>
                          <li
                            class="
                              list-group-item
                              bg-dark-gp
                              border-0
                              select-filter-gp
                            "
                          >
                            <div v-if="giaoHatLists">
                              <model-select
                                :options="giaoHatLists"
                                v-model="giaoHat"
                                placeholder="Chọn Giáo Hạt"
                              ></model-select>
                            </div>
                          </li>
                          <li class="list-group-item bg-dark-gp border-0">
                            <input
                              v-model="query"
                              type="search"
                              class="form-control-sm rounded border-0"
                              placeholder="Nhập tìm kiếm"
                              aria-label="Search"
                              aria-describedby="search-addon"
                            />
                          </li>
                          <li
                            class="list-group-item bg-dark-gp border-0"
                            @click.prevent="filterGiaoXu"
                          >
                            <a class="input-group-text" style="cursor: pointer">
                              <i class="fas fa-search"></i>
                            </a>
                          </li>
                        </ul>
                      </div>
                      <div class="mt-4" v-if="giaoXuLists">
                        <div class="list-giao-xu">
                          <div
                            v-for="(info, idx) in giaoXuLists"
                            :key="idx + 'A'"
                            class="row row-linh-muc"
                          >
                            <div class="col-mobile col-2">
                              <a class="avatar" :href="info.hrefDetail">
                                <img
                                  class="img"
                                  v-lazy="info.image"
                                  :alt="info.name"
                                />
                              </a>
                            </div>
                            <div class="col-mobile col-10 content">
                              <h4 class="tit">
                                <a :href="info.hrefDetail">
                                  Giáo Xứ {{ info.name }}</a
                                >
                              </h4>
                              <div class="row">
                                <div class="col-6">
                                  <span
                                    >Giờ lễ: <span v-html="info.gio_le"></span
                                  ></span>
                                  <span>Địa chỉ: {{ info.dia_chi }}</span>
                                  <span>Email: {{ info.email }}</span>
                                </div>
                                <div class="col-6">
                                  <span>Điện thoại: {{ info.dien_thoai }}</span>
                                  <span>Dân số: {{ info.dan_so }}</span>
                                  <span>Số tín hữu: {{ info.so_tin_huu }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <PaginationFilter
                        v-if="paginationFilter.last_page > 1"
                        v-bind:pagination="paginationFilter"
                        v-on:click.native="getCurrentPageFilter(paginationFilter.current_page)"
                        :offset="4"
                      >
                      </PaginationFilter>
                    </div>
                  </b-tab>
                </b-tabs>
              </div>
            </div>
          </template>
        </main-content>
        <content-bottom v-if="_isContentBottom"> </content-bottom>
      </div>
    </div>
  </main>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import { MODULE_GIAO_XU_PAGE, } from '@app/stores/front/types/module-types'
import {
  GET_LISTS,
  GET_LISTS_GIAO_PHAN,
  GET_LISTS_GIAO_HAT,
  GET_LISTS_GIAO_XU,
  ACTION_GET_PAGE_FILTER,
  ACTION_REFESH_LIST_FILTER,
} from '@app/stores/front/types/action-types'
import MainMenu from 'com@front/Common/MainMenu'
import ContentTop from 'com@front/Common/ContentTop'
import ContentBottom from 'com@front/Common/ContentBottom'
import SocialNetwork from 'com@front/Common/SocialNetwork'
import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular'
import NewsletterRegister from 'com@front/Common/NewsletterRegister'
import MainContent from 'com@front/Common/MainContent'
import ModulePageBannerList from 'v@front/modules/page_banner_lists'
import Paginate from 'com@front/Pagination'
import PaginationFilter from 'com@front/PaginationFilter'
import 'vue-search-select/dist/VueSearchSelect.css'
import { ModelSelect, } from 'vue-search-select'

export default {
  name: 'GiaoXuPage',
  components: {
    MainMenu,
    TabInfoViewedAndPopular,
    ContentTop,
    ContentBottom,
    SocialNetwork,
    NewsletterRegister,
    MainContent,
    ModulePageBannerList,
    Paginate,
    ModelSelect,
    PaginationFilter,
  },
  data() {
    return {
      isContentBottom: false,
      fullPage: false,
      isTopBottomBoth: false,
      imgCarousel: 'https://picsum.photos/1024/480/?image=58',
      isResource: false,
      giaoPhan: '',
      giaoHat: '',
      query: '',
      offset: 4,
    }
  },
  watch: {
    giaoPhan() {
      this.giaoHat = ''
      this.getListGiaoHat(this.giaoPhan)
    },
  },
  computed: {
    ...mapState({
      contentBgColor: (state) => state.cfApp.setting.contentBgColor,
    }),
    ...mapState(MODULE_GIAO_XU_PAGE, {
      infoList: (state) => state.pageLists,
      giaoPhanLists: (state) => state.giaoPhanLists,
      giaoHatLists: (state) => state.giaoHatLists,
      loading: (state) => state.loading,
      giaoXuLists: (state) => state.giaoXuLists,
      paginationFilter: (state) => state.paginationFilter,
    }),
    _isContentTop() {
      return this.$route.meta.layout_content.content_top
    },
    _isContentBottom() {
      return false // this.$route.meta.layout_content.content_bottom
    },
    _isContentMain() {
      return this.$route.meta.layout_content.content_main
    },
  },
  created() {
    this.getList(this.$route.params)
    this.getListGiaoPhan()
  },
  methods: {
    ...mapActions(MODULE_GIAO_XU_PAGE, {
      getList: GET_LISTS,
      getListGiaoPhan: GET_LISTS_GIAO_PHAN,
      getListGiaoHat: GET_LISTS_GIAO_HAT,
      getListGiaoXu: GET_LISTS_GIAO_XU,
      getPageFilter: ACTION_GET_PAGE_FILTER,
      refreshListFilter: ACTION_REFESH_LIST_FILTER,
    }),
    isBlank(str) {
      return !str || /^\s*$/.test(str)
    },
    getCurrentPageFilter(page) {
      this.getListGiaoXu({
        params: this.giaoHat,
        page: page,
        query: this.query,
      })
    },
    filterGiaoXu() {
      if (this.isBlank(this.query) && this.giaoHat == '') {
        this.refreshListFilter()
      } else {
        this.getListGiaoXu({
          params: this.giaoHat,
          page: 1,
          query: this.query,
        })
      }
    },
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>

