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
          <template #column_right>
            <social-network></social-network>
            <div class="box-social">
              <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
            </div>
          </template>
        </content-top>
        <main-content v-if="_isContentMain">
          <!--<template #before_column_both>
                <div class="col-mobile col-12">
                    <module-page-banner-list></module-page-banner-list>
                </div>
            </template>-->
          <template #bottom>
            <!-- Html linh mục detail -->
            <div class="list-danh-muc w-100">
              <h2 class="title-linh-muc text-center">
                Danh sách linh mục đoàn giáo phận phú cường
                <hr class="line-linh-muc" />
              </h2>
              <div class="tab-linh-muc w-100">
                <b-tabs content-class="mt-3" fill>
                  <b-tab title="Tất cả" active>
                    <div class="list-linh-muc">
                      <!-- Load danh sach linh muc -->
                      <div
                        v-for="(info, idx) in pageLists"
                        :key="idx"
                        class="row row-linh-muc"
                      >
                        <div class="col-mobile col-2">
                          <a
                            class="avatar"
                            :href="`/linh-muc/chi-tiet/${info.id}`"
                          >
                            <img
                              class="img"
                              :src="`${info.image}`"
                              alt="Hình ảnh đại diện"
                            />
                          </a>
                        </div>
                        <div class="col-mobile col-10 content">
                          <h4 class="tit">
                            <a :href="`/linh-muc/chi-tiet/${info.id}`">{{
                              info.ten_day_du
                            }}</a>
                          </h4>
                          <div class="row">
                            <div class="col-6">
                              <span v-if="info.ngay_rip">RIP: {{ info.ngay_rip }}</span>
                              <span v-else>Chức vụ: {{ info.chuc_vu }}</span>
                              
                              <a :href="info.href_giaoxu">
                                <span v-if="info.chuc_vu === 'Hưu'">Nơi nghỉ hưu: {{ info.noi_nghi_huu }} </span>
                                 <span v-else-if="info.chuc_vu === 'R.I.P'">Nơi RIP: {{ info.noi_nghi_huu }} </span>
                                <span v-else>Nơi phục vụ: {{ info.giao_xu }}</span>
                              </a>
                              <span>Giáo hạt: {{ info.giao_hat }}</span>
                            </div>
                            <div class="col-6">
                              <span>Năm sinh: {{ info.nam_sinh }}</span>
                              <span>Chịu chức: {{ info.ngay_nhan_chuc }}</span>
                              <span>Địa chỉ: {{ info.dia_chi }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <paginate
                      :is-resource="isResource"
                      v-if="pageLists"
                    ></paginate>
                  </b-tab>
                  <b-tab title="Lọc theo chức vụ / Giáo hạt">
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
                              key="chuc_vu"
                              :options="chucVuLists"
                              v-model="chucVu"
                              placeholder="Chọn Chức Vụ"
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
                            <model-select
                              key="giao_hat"
                              :options="giaoHatLists"
                              v-model="giaoHat"
                              placeholder="Chọn Giáo Hạt"
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
                            @click.prevent="filterLinhMuc"
                          >
                            <a class="input-group-text" style="cursor: pointer">
                              <i class="fas fa-search"></i>
                            </a>
                          </li>
                        </ul>
                      </div>
                      <div class="mt-4" v-if="linhMucLists.length">
                        <div class="list-linh-muc">
                          <div
                            v-for="(info, idx) in linhMucLists"
                            :key="idx + 'A'"
                            class="row row-linh-muc"
                          >
                            <div class="col-mobile col-2">
                              <a
                                class="avatar"
                                :href="`/linh-muc/chi-tiet/${info.id}`"
                              >
                                <img
                                  class="img"
                                  :src="`${info.image}`"
                                  alt="Hình ảnh đại diện"
                                />
                              </a>
                            </div>
                            <div class="col-mobile col-10 content">
                              <h4 class="tit">
                                <a :href="`/linh-muc/chi-tiet/${info.id}`">{{
                                  info.ten_day_du
                                }}</a>
                              </h4>
                              <div class="row">
                                <div class="col-6">
                                  <span v-if="info.ngay_rip">RIP: {{ info.ngay_rip }}</span>
                                  <span v-else>Chức vụ: {{ info.chuc_vu }}</span>
                                  
                                  <a :href="info.href_giaoxu">
                                    <span v-if="info.chuc_vu === 'Hưu'">Nơi nghỉ hưu: {{ info.noi_nghi_huu }} </span>
                                    <span v-else-if="info.chuc_vu === 'R.I.P'">Nơi RIP: {{ info.noi_nghi_huu }} </span>
                                    <span v-else>Nơi phục vụ: {{ info.giao_xu }}</span>
                                    </a>
                                    <span>Giáo hạt: {{ info.giao_hat }}</span>
                                  </div>
                                  <div class="col-6">
                                    <span>Năm sinh: {{ info.nam_sinh }}</span>
                                    <span>Chịu chức: {{ info.ngay_nhan_chuc }}</span>
                                    <span>Địa chỉ: {{ info.dia_chi }}</span>
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
import {
  MODULE_LINH_MUC_PAGE,
  MODULE_GIAO_XU_PAGE,
} from '@app/stores/front/types/module-types'
import {
  GET_LISTS_LINH_MUC,
  GET_LISTS_GIAO_HAT,
  GET_LISTS_CHUC_VU,
  GET_LISTS_LINH_MUC_BY_ID,
  ACTION_GET_PAGE_FILTER,
  ACTION_REFESH_LIST_FILTER,
} from '@app/stores/front/types/action-types'
import MainMenu from 'com@front/Common/MainMenu'
import ContentTop from 'com@front/Common/ContentTop'
import ContentBottom from 'com@front/Common/ContentBottom'
import SocialNetwork from 'com@front/Common/SocialNetwork'
import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular'
import MainContent from 'com@front/Common/MainContent'
import Paginate from 'com@front/Pagination'
import PaginationFilter from 'com@front/PaginationFilter'
import 'vue-search-select/dist/VueSearchSelect.css'
import { ModelSelect, } from 'vue-search-select'

export default {
  name: 'InfoPage',
  components: {
    MainMenu,
    TabInfoViewedAndPopular,
    ContentTop,
    ContentBottom,
    SocialNetwork,
    MainContent,
    Paginate,
    PaginationFilter,
    ModelSelect,
  },
  data() {
    return {
      isContentBottom: true,
      fullPage: true,
      isTopBottomBoth: false,
      imgCarousel: 'https://picsum.photos/1024/480/?image=58',
      isResource: false,
      chucVu: '',
      giaoHat: '',
      query: '',
      offset: 4,
    }
  },
  computed: {
    ...mapState({
      contentBgColor: state => state.cfApp.setting.contentBgColor,
    }),
    ...mapState(MODULE_LINH_MUC_PAGE, {
      pageLists: state => state.pageLists,
      linhMucLists: state => state.linhMucLists,
      chucVuLists: state => state.chucVuLists,
      loading: state => state.loading,
      paginationFilter: state => state.paginationFilter,
    }),
    ...mapState(MODULE_GIAO_XU_PAGE, {
      giaoHatLists: state => state.giaoHatLists,
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
  created() {
    this.getList(this.$route.params)
    this.getListGiaoHat(-1)
    this.getListChucVu()
  },
  methods: {
    ...mapActions(MODULE_LINH_MUC_PAGE, {
      getList: GET_LISTS_LINH_MUC,
      getListChucVu: GET_LISTS_CHUC_VU,
      getListLinhMuc: GET_LISTS_LINH_MUC_BY_ID,
      getPageFilter: ACTION_GET_PAGE_FILTER,
      refreshListFilter: ACTION_REFESH_LIST_FILTER,
    }),
    ...mapActions(MODULE_GIAO_XU_PAGE, {
      getListGiaoHat: GET_LISTS_GIAO_HAT,
    }),
    isBlank(str) {
      return !str || /^\s*$/.test(str)
    },
    getCurrentPageFilter(page) {
      this.getListLinhMuc({
        id_chucvu: this.chucVu,
        id_giaohat: this.giaoHat,
        page: page,
        query: this.query,
      })
    },
    filterLinhMuc() {
      if (this.isBlank(this.query) && this.giaoHat == '' && this.chucVu == '') {
        this.refreshListFilter()
      } else {
        this.getListLinhMuc({
          id_chucvu: this.chucVu,
          id_giaohat: this.giaoHat,
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
