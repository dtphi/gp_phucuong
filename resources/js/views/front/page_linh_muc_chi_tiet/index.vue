<template>
  <main id="news" class="tab-content">
    <div class="form-group mt-2">
      <div class="col-sm-10">
        <h2>THÔNG TIN CÁ NHÂN</h2>
      </div>
    </div>
    <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-10">
        <h3><a :href="linhmuc_update.link_hdsv">Hoạt động sứ vụ</a></h3>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-sinh-giao-xu" class="col-sm-2 control-label">Tên thánh:</h5>
      <div class="col-sm-10">
         <select v-model="linhmuc_update.ten_thanh_id" class="custom-select">
          <option v-for="(item, index) in linhmuc_update.thanhs" :key="index"  :value="item.id">{{ item.name }}</option>
        </select>
      </div>
    </div>
		<div class="form-group">
      <h5 for="input-info-sinh-giao-xu" class="col-sm-2 control-label">Sinh tại xứ:</h5>
      <div class="col-sm-10">
        <validation-provider
          name="info_sinh_giao_xu"
          rules="max:255"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.sinh_giao_xu"
            type="text"
            id="input-info-sinh-giao-xu"  
            class="form-control"
            placeholder="Sinh tại giáo xứ"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-name" class="col-sm-2 control-label">Tên</h5>
      <div class="col-sm-10">
        <validation-provider
          name="info_name"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.ten"
            type="text"
            id="input-info-name"
            class="form-control"
            placeholder="Tên"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
		<div class="form-group">
      <h5 for="input-info-cham-ngon" class="col-sm-2 control-label">Châm ngôn</h5>
      <div class="col-sm-10">
        <validation-provider
          name="info_cham_ngon"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.cham_ngon"
            type="text"
            id="input-info-cham-ngon"
            class="form-control"
            placeholder="Châm ngôn"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ngay-thang-nam-sinh" class="col-sm-2 control-label"
        >Ngày sinh:</h5
      >
      <div class="col-sm-3">
          <cms-date-picker
            value-type="format"
            format="YYYY-MM-DD"
            v-model="linhmuc_update.ngay_thang_nam_sinh"
            type="date"
          ></cms-date-picker>
      </div>
      <div class="col-sm-5">
        <label class="control-label">{{
          linhmuc_update.lable_ngay_thang_nam_sinh
        }}</label>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-noi-sinh" class="col-sm-2 control-label"
        >Nơi sinh</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_sinh"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            id="input-info-noi-sinh"
            v-model="linhmuc_update.noi_sinh"
            class="form-control"
            placeholder="Nơi sinh"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ho-ten-cha" class="col-sm-2 control-label"
        >Họ tên cha</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_ho_ten_cha"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.ho_ten_cha"
            type="text"
            id="input-info-ho-ten-cha"
            class="form-control"
            placeholder="Họ tên cha"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ho-ten-me" class="col-sm-2 control-label"
        >Họ tên mẹ</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_ho_ten_me"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.ho_ten_me"
            type="text"
            id="input-info-ho-ten-me"
            class="form-control"
            placeholder="Họ tên mẹ"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-noi-rua-toi" class="col-sm-2 control-label"
        >Nơi rửa tội</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_rua_toi"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.noi_rua_toi"
            type="text"
            id="input-info-noi-rua-toi"
            class="form-control"
            placeholder="Nơi rửa tội"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ngay-rua-toi" class="col-sm-2 control-label"
        >Ngày rửa tội:</h5
      >
      <div class="col-sm-3">
          <cms-date-picker
            value-type="format"
            format="YYYY-MM-DD"
            v-model="linhmuc_update.ngay_rua_toi"
            type="date"
          ></cms-date-picker>
      </div>
      <div class="col-sm-5">
        <label class="control-label">{{
          linhmuc_update.lable_ngay_rua_toi
        }}</label>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-noi-them-suc" class="col-sm-2 control-label"
        >Nơi thêm sức</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_them_suc"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.noi_them_suc"
            type="text"
            id="input-info-noi-them-suc"
            class="form-control"
            placeholder="Nơi thêm sức"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ngay-them-suc" class="col-sm-2 control-label"
        >Ngày thêm sức:</h5
      >
      <div class="col-sm-3">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="linhmuc_update.ngay_them_suc"
          type="date"
        ></cms-date-picker>
      </div>
      <div class="col-sm-5">
        <label class="control-label">{{
          linhmuc_update.lable_ngay_them_suc
        }}</label>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-tieu-chung-vien" class="col-sm-2 control-label"
        >Tiểu chủng viện</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_tieu_chung_vien"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.tieu_chung_vien"
            type="text"
            id="input-info-tieu-chung-vien"
            class="form-control"
            placeholder="Tiểu chủng viện"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5
        for="input-info-ngay-tieu-chung-vien"
        class="col-sm-2 control-label"
        >Ngày tiểu chủng viện:</h5
      >
      <div class="col-sm-3">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="linhmuc_update.ngay_tieu_chung_vien"
          type="date"
        ></cms-date-picker>
      </div>
      <div class="col-sm-5">
        <label class="control-label">{{
          linhmuc_update.lable_ngay_tieu_chung_vien
        }}</label>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-dai-chung-vien" class="col-sm-2 control-label"
        >Đại chủng viện</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_dai_chung_vien"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.dai_chung_vien"
            type="text"
            id="input-info-dai-chung-vien"
            class="form-control"
            placeholder="Đại chủng viện"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ngay-dai-chung-vien" class="col-sm-2 control-label"
        >Ngày đại chủng viện:</h5
      >
      <div class="col-sm-3">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="linhmuc_update.ngay_dai_chung_vien"
          type="date"
        ></cms-date-picker>
      </div>
      <div class="col-sm-5">
        <label class="control-label">{{
          linhmuc_update.lable_ngay_dai_chung_vien
        }}</label>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-trieu-dong" class="col-sm-2 control-label"
        >Triệu dòng:</h5>
      <div class="col-sm-5">
          <div class="col-sm-10">
              <select class="form-control" v-model="linhmuc_update.trieu_dong">
                <option value="1" :selected="linhmuc_update.trieu_dong == 1">Tu Dòng</option>
                <option value="0" :selected="linhmuc_update.trieu_dong == 0">Tu Triều</option>
              </select>
            </div>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-sinh-giao-xu" class="col-sm-2 control-label">Tên dòng:</h5>
      <div class="col-sm-10">
         <select v-model="linhmuc_update.ten_dong_id" class="custom-select">
          <option v-for="(item, index) in linhmuc_update.dongs" :key="index + 'A'"  :value="item.id">{{ item.name }}</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ngay-trieu-dong" class="col-sm-2 control-label"
        >Ngày triệu dòng:</h5
      >
      <div class="col-sm-3">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="linhmuc_update.ngay_trieu_dong"
          type="date"
        ></cms-date-picker>
      </div>
      <div class="col-sm-5">
        <label class="control-label">{{
          linhmuc_update.lable_ngay_trieu_dong
        }}</label>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ngay-khan" class="col-sm-2 control-label"
        >Ngày khấn:</h5
      >
      <div class="col-sm-3">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="linhmuc_update.ngay_khan"
          type="date"
        ></cms-date-picker>
      </div>
      <div class="col-sm-5">
        <label class="control-label">{{ linhmuc_update.lable_ngay_khan }}</label>
      </div>
    </div>
    <!-- TEST -->
    <div class="form-group">
      <h5 for="input-info-duc-cha" class="col-sm-2 control-label"
        >Chức Vụ</h5
      >
      <div class="col-sm-2">
        <label>Là đức cha</label>
        <input
          v-model="linhmuc_update.is_duc_cha"
          type="checkbox"
          id="input-info-duc-cha"
        />
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-so-dien-thoai" class="col-sm-2 control-label"
        >Sô điện thoại</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_so_dien_thoai"
          rules="max:20"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.phone"
            type="text"
            id="input-info-so-dien-thoai"
            class="form-control"
            placeholder="Số điện thoại"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-email" class="col-sm-2 control-label">Email</h5>
      <div class="col-sm-10">
        <validation-provider
          name="info_email"
          rules="email|max:200"
          v-slot="{ errors }"
        >
          <input
            autocomplete="off"
            v-model="linhmuc_update.email"
            type="text"
            id="input-info-email"
            class="form-control"
            placeholder="Email"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-so-cmnd" class="col-sm-2 control-label"
        >Số CMND</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_so_cmnd"
          rules="max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.so_cmnd"
            type="text"
            id="input-info-so-cmnd"
            class="form-control"
            placeholder="Số Cmnd"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-noicap-cmnd" class="col-sm-2 control-label"
        >Nơi cấp CMND:</h5
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noicap_cmnd"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="linhmuc_update.noi_cap_cmnd"
            type="text"
            id="input-info-noicap-cmnd"
            class="form-control"
            placeholder="Nơi cấp Cmnd"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <h5 for="input-info-ngay-cap-cmnd" class="col-sm-2 control-label"
        >Ngày cấp CMND:</h5
      >
      <div class="col-sm-10">
        <cms-date-picker
          value-type="format"
          format="YYYY-MM-DD"
          v-model="linhmuc_update.ngay_cap_cmnd"
          type="date"
        ></cms-date-picker>
      </div>
    </div>
    <div class="form-group">
      <div class="cl-osm-10">
        <button @click="updateLinhMuc()" class="btn btn-primary">CẬP NHẬT</button>
      </div>
    </div>
  </div>
  </main>
</template>

<script>
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { mapState, mapActions, } from 'vuex'
import MainMenu from 'com@front/Common/MainMenu'
import ContentTop from 'com@front/Common/ContentTop'
import ContentBottom from 'com@front/Common/ContentBottom'
import SocialNetwork from 'com@front/Common/SocialNetwork'
import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular'
import MainContent from 'com@front/Common/MainContent'

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
      selected: null,
    }
  },
  computed: {
    ...mapState({
      contentBgColor: state => state.cfApp.setting.contentBgColor,
      logoBgColor: state => state.cfApp.setting.logoBgColor,
    }),
    ...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
        linhmuc_update: state => {
        return state.linhmuc_update
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
    this.GET_LINH_MUC_UPDATE_BY_ID(this.$route.params)
  },
  methods: {
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'GET_LINH_MUC_UPDATE_BY_ID',
      'UPDATE_LINH_MUC_DETAIL',
    ]),
    async updateLinhMuc() {
      await this.UPDATE_LINH_MUC_DETAIL(this.linhmuc_update)
    }
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>
