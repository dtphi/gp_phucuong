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
          <template #before>
            <!-- Html linh mục detail -->
            <div class="col-mobile col-12">
              <div class="detail-linh-muc w-100">
                <div class="row">
                  <div class="col-mobile col-4">
                    <div class="bi-tich p-3 mt-3">
                      <div
                        class="d-block avatar-img mt-3"
                        style="margin-bottom: 15px"
                      >
                        <img
                          class="img"
                          :src="`${pageLists.image}`"
                          :alt="pageLists.ten"
                        />
                      </div>
                      <p class="col-4 text-uppercase">Linh mục</p>
                      <div class="col-8">
                        <p
                          style="font-size: 20px; margin-bottom: 0.1rem"
                          class="text-uppercase"
                        >
                          {{ pageLists.ten_thanh }}
                        </p>
                        <p
                          style="
                            font-weight: bold;
                            font-size: 16px;
                            margin-bottom: 0.1rem;
                          "
                          class="text-uppercase"
                        >
                          {{ pageLists.ten }}
                        </p>
                        <p>{{ pageLists.cv_hien_tai }}</p>
                      </div>
                      <h4 class="text-uppercase text-center mb-3">Bí tích</h4>
                      <a
                        style="font-size: 25px"
                        class="d-block"
                        href="javascript:void(0);"
                        >Bí tích Rửa Tội</a
                      >
                      <p
                        style="margin-bottom: 2rem; font-size: 20px"
                        class="d-block"
                      >
                        {{ pageLists.ngay_rua_toi }}
                      </p>
                      <a
                        style="font-size: 25px"
                        class="d-block"
                        href="javascript:void(0);"
                        >Bí tích Thêm sức
                      </a>
                      <p
                        style="margin-bottom: 2rem; font-size: 20px"
                        class="d-block"
                      >
                        {{ pageLists.ngay_them_suc }}
                      </p>
                      <a
                        style="font-size: 25px"
                        class="d-block"
                        href="javascript:void(0);"
                        >Bí tích Truyền Chức
                      </a>
                      <p
                        style="margin-bottom: 2rem; font-size: 20px"
                        v-for="(value, idx) in pageLists.ds_chuc_thanh"
                        :key="value.chuc_thanh_id + '_ct'"
                        class="d-block"
                      >
                        {{ idx + 1 + ". " + chucThanh[value.chuc_thanh_id]
                        }}<br />
                        <span style="font-size: 14px"
                          >Thụ phong bởi :<br />
                          {{ value.nguoi_thu_phong }}</span
                        ><br />
                        <span style="font-size: 14px"
                          >Tại: {{ value.noi_thu_phong }}</span
                        ><br />
                        <span style="font-size: 14px"
                          >Ngày :
                          {{ value.label_ngay_thang_nam_chuc_thanh }}</span
                        ><br />
                      </p>
                    </div>
                  </div>
                  <div class="col-mobile col-8">
                    <div class="info-personal mt-5" style="font-size: 0.87rem">
                      <h4 class="text-uppercase">Thông tin cá nhân</h4>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-5">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 97px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >..................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 97px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...............................................</label
                          >
                          Ngày sinh:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ $helper.fn_format_dd_mm_yyyy(pageLists.nam_sinh) }}</label
                          ></span
                        >
                        <span class="col-mobile col-6">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 39px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...............................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 41px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >............................................................</label
                          >
                          tại:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.dia_chi }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-5">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >......................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................................</label
                          >
                          Giáo xứ:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.giao_xu }}</label
                          >
                        </span>
                        <span class="col-mobile col-6">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 100px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >.................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 99px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...............................................</label
                          >
                          Giáo phận:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.giao_phan }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-11">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 82px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >..........................................................................................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 82px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................................</label
                          >
                          Tên cha:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.ho_ten_cha }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-11">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 78px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...........................................................................................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 78px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >....................................................</label
                          >
                          Tên mẹ:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.ho_ten_me }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-11">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 71px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >.............................................................................................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 71px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >.....................................................</label
                          >
                          CMND:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.so_cmnd }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-5">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 94px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 93px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >................................................</label
                          >
                          Ngày cấp:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ $helper.fn_format_dd_mm_yyyy(pageLists.ngay_cap_cmnd) }}</label
                          >
                        </span>
                        <span class="col-mobile col-6">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >......................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................................</label
                          >
                          Nơi cấp:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.noi_cap_cmnd }}</label
                          >
                        </span>
                      </p>
                    </div>
                    <div class="maxim text-center">
                      <h4
                        class="tit-maxim"
                        :style="`border: 4px solid ${logoBgColor}`"
                      >
                        Châm ngôn đời linh mục
                      </h4>
                    </div>
                    <div>
                      <h3>HOẠT ĐỘNG SỨ VỤ</h3>
                      <a
                        :href="`/linhmucadmin/dashboard?linhmucId=${pageLists.id}`"
                        >Đến trang quản trị</a
                      >
                      <vue-timeline-update
                        v-for="item in pageLists.ds_chuc_vu"
                        :key="item.id"
                        :date="new Date()"
                        :dateString="item.label_from_date"
                        :category="`Chức vụ: ${item.chucvuName}`"
                        :title="`- <a href='/giao-xu/chi-tiet/${item.giao_xu_id}'>Giáo xứ: ${item.giaoxuName}</a>`"
                        :description="_des(item)"
                        icon="history"
                      />
                    </div>
                  </div>
                </div>
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
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { GET_DETAIL_LINH_MUC, } from '@app/stores/front/types/action-types'
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
      chucThanh: ['', 'Phó Tế', 'Linh Mục', 'Giám Mục'],
      chucVus: [],
    }
  },
  computed: {
    ...mapState({
      contentBgColor: state => state.cfApp.setting.contentBgColor,
      logoBgColor: state => state.cfApp.setting.logoBgColor,
    }),
    ...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
      pageLists: state => {
        return state.pageLists
      },
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
    this.getDetail(this.$route.params)
  },
  methods: {
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, {
      getDetail: GET_DETAIL_LINH_MUC,
    }),
    _des(item) {
      var fromDate = item.label_from_date
      var toDate = item.label_to_date ? ' đến ngày ' + item.label_to_date : ''
      var des = 'Từ ngày ' + fromDate + toDate + ' ' + item.ghi_chu
      
      return des
    },
    _itemChucVus(chucVus) {
      const self = this
      if (self.chucVus.length) {
        return self.chucVus
      }
      if (chucVus && chucVus.length) {
        chucVus.forEach((item, idx) => {
          var fromDate = item.label_from_date
          var toDate = item.label_to_date ? ` đến ngày ${item.label_to_date}` : ''
          var title = `${item.chucvuName} - Giáo xứ: ${item.giaoxuName}`
          var des = `Từ ngày ${fromDate} ${toDate} ${item.ghi_chu}`
          self.chucVus.push(
            new Item(
              idx,
              'edit',
              Status.INFO,
              title,
              [],
              item.from_date ? new Date(item.from_date) : '',
              des
            )
          )
        })
      }
      
      return self.chucVus
    },
    edit(e) {
      console.log('edit ' + e['eventId'])
    },
    reset() {
      this.item = {}
    },
    selectFromParentComponent1() {
      // select option from parent component
      this.item = this.options[0]
    },
    reset2() {
      this.item2 = ''
    },
    selectFromParentComponent2() {
      // select option from parent component
      this.item2 = this.options2[0].value
    },
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>
