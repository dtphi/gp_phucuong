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
          <template #column_middle v-if="info">
            <h2>Giáo xứ {{ info.name }}</h2>
            <img style="width: 100%; margin-bottom: 15px" :src="info.image" />
            <div class="row">
              <div class="col-lg-6 col-md-12 col-xs-12">
                 <vue-timeline-update v-for="(info, idx) in info.arr_chanh_xu" :key="idx + 'A'"
                  :date="new Date()"
                  dateString="#"
                  :category="`Linh mục chánh xứ`"
                  title="."
                  :thumbnail="info.img_chanh_xu"
                  :description="`<div>
                    <h5>${info.chanh_xu}</h5>
                    <h5>${info.from_date_chanh}</h5>
                    <h5>${info.email_chanh}</h5>
                  </div>`"
                  icon="account_circle"
                /> 
                <vue-timeline-update v-for="(info, idx) in info.arr_pho_xu" :key="idx"
                  :date="new Date()"
                  dateString="-"
                  :category="`Linh mục phó xứ`"
                  title="."
                  :thumbnail="info.img_pho_xu"
                  :description="`<div>
                    <h5>${info.pho_xu}</h5>
                    <h5>${info.from_date_pho}</h5>
                    <h5>${info.email_pho}</h5>
                  </div>`"
                  icon="account_circle"
                />
                <vue-timeline-update v-if="info.ngay_thanh_lap"
                  :date="new Date()"
                  dateString="#"
                  :category="`Ngày thành lập`"
                  title="."
                  :description="$helper.fn_format_dd_mm_yyyy(info.ngay_thanh_lap)"
                  icon="home"
                />
                <vue-timeline-update v-if="info.so_tin_huu"
                  :date="new Date()"
                  dateString="#"
                  :category="`Giáo dân: ${info.so_tin_huu}`"
                  title="."
                  :description="info.dan_so"
                  icon="people"
                />
                <vue-timeline-update v-if="info.gio_le"
                  :date="new Date()"
                  dateString="#"
                  category="Giờ cử hành thánh lễ"
                  title="."
                  :description="info.gio_le"
                  icon="schedule"
                />
                <vue-timeline-update v-if="info.dia_chi"
                  :date="new Date()"
                  dateString="#"
                  category="Địa chỉ giáo xứ"
                  title="."
                  :description="info.dia_chi"
                  icon="room"
                />
                <vue-timeline-update v-if="info.dien_thoai"
                  :date="new Date()"
                  dateString="#"
                  category="Điện thoại"
                  title="."
                  :description="info.dien_thoai"
                  icon="phone"
                />
                <vue-timeline-update v-if="info.email"
                  :date="new Date()"
                  dateString="#"
                  category="E-mail"
                  title="."
                  :description="info.email"
                  icon="markunread"
                />
                <vue-timeline-update v-if="info.linh_muc_tien_nhiem"
                  :date="new Date()"
                  dateString="#"
                  category="Linh mục tiền nhiệm"
                  title="."
                  :description="info.linh_muc_tien_nhiem"
                  icon="group"
                />
              </div>
              <div class="col-lg-6 col-md-12 col-xs-12">
                <vue-timeline-update v-if="info.sub_noi_dung"
                  :date="new Date()"
                  dateString="-"
                  category="Lịch sử giáo xứ"
                  title="."
                  :description="info.sub_noi_dung"
                  icon="history"
                />
              </div>
            </div>
          </template>
        </main-content>
        <content-bottom v-if="_isContentBottom"> </content-bottom>
      </div>
    </div>
    <!-- Modal -->
    <b-modal size="xl" id="giaoXuHistoryFull" hide-footer>
      <template #modal-title>
        <code>Lịch sử giáo xứ</code>
      </template>
      <div class="d-block text-center" v-if="info">
        <div v-html="info.noi_dung"></div>
      </div>
      <b-button class="mt-3" block @click="$bvModal.hide('giaoXuHistoryFull')"
        >Đóng</b-button
      >
    </b-modal>
  </main>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import { MODULE_GIAO_XU_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { GET_DETAIL, } from '@app/stores/front/types/action-types'
import MainMenu from 'com@front/Common/MainMenu'
import ContentTop from 'com@front/Common/ContentTop'
import ContentBottom from 'com@front/Common/ContentBottom'
import SocialNetwork from 'com@front/Common/SocialNetwork'
import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular'
import MainContent from 'com@front/Common/MainContent'
import Vue from 'vue'
import vuetimeline from '@growthbunker/vuetimeline'
Vue.use(vuetimeline)

export default {
  name: 'InfoPage',
  components: {
    MainMenu,
    TabInfoViewedAndPopular,
    ContentTop,
    ContentBottom,
    SocialNetwork,
    MainContent,
  },
  data() {
    return {
      isContentBottom: true,
      fullPage: false,
      isTopBottomBoth: false,
      imgCarousel: 'https://picsum.photos/1024/480/?image=58',
    }
  },
  computed: {
    ...mapState({
      contentBgColor: (state) => state.cfApp.setting.contentBgColor,
    }),
    ...mapState(MODULE_GIAO_XU_DETAIL_PAGE, {
      info: (state) => state.pageLists.results,
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
    this.getDetail(this.$route.params)
    window.$bvModal = this.$bvModal
  },
  methods: {
    ...mapActions(MODULE_GIAO_XU_DETAIL_PAGE, {
      getDetail: GET_DETAIL,
    }),
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>
