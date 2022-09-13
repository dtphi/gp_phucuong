<template>
  <form class="form-horizontal" autocomplete="off">
    <ul class="nav nav-tabs">
      <li class="active" @click="currentTab = 'general'">
        <a href="#tab-general" data-toggle="tab">{{
          $options.setting.tab_general_title
        }}</a>
      </li>
      <li @click="currentTab = 'mo_rong'">
        <a href="#tab-mo-rong" data-toggle="tab" >{{
          $options.setting.tab_mo_rong_title
        }}</a>
      </li>
      <li @click="currentTab = 'bang_cap'">
        <a href="#tab-bang-cap" data-toggle="tab">{{
          $options.setting.tab_bang_cap_title
        }}</a>
      </li>
      <li @click="currentTab = 'chuc_thanh'">
        <a href="#tab-chuc-thanh" data-toggle="tab">{{
          $options.setting.tab_chuc_thanh_title
        }}</a>
      </li>
      <li @click="currentTab = 'van_thu'">
        <a href="#tab-van-thu" data-toggle="tab">{{
          $options.setting.tab_van_thu_title
        }}</a>
      </li>
      <li @click="currentTab = 'thuyen_chuyen'">
        <a href="#tab-thuyen-chuyen" data-toggle="tab">{{
          $options.setting.tab_thuyen_chuyen_title
        }}</a>
      </li>
      <li @click="currentTab = 'bo_nhiem_khac'">
        <a href="#tab-bo-nhiem-khac" data-toggle="tab">{{
          $options.setting.tab_bo_nhiem_khac_title
        }}</a>
      </li>
      <li @click="currentTab = 'ho_so'">
        <a href="#tab-ho-so" data-toggle="tab">{{
          $options.setting.tab_ho_so_title
        }}</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general" v-if="currentTab == 'general'">
        <tab-general
          role="tabpanel"
          class="tab-pane active"
          :general-data="info"
          :mmSelected="selected"
          :mmPath="imgSelected"
        ></tab-general>
      </div>
      <div class="tab-pane" id="tab-mo-rong" v-if="currentTab == 'mo_rong'">
        <tab-mo-rong
          role="tabpanel"
          class="tab-pane"
          :general-data="info"
          :mmSelected="selected"
          :mmPath="imgSelected"
        ></tab-mo-rong>
      </div>
      <div class="tab-pane" id="tab-bang-cap" v-if="currentTab == 'bang_cap'">
        <tab-bang-cap
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-bang-cap>
      </div>
      <div class="tab-pane" id="tab-chuc-thanh" v-if="currentTab == 'chuc_thanh'">
        <tab-chuc-thanh
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-chuc-thanh>
      </div>
      <div class="tab-pane" id="tab-van-thu" v-if="currentTab == 'van_thu'">
        <tab-van-thu
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-van-thu>
      </div>
      <div class="tab-pane" id="tab-thuyen-chuyen" v-if="currentTab == 'thuyen_chuyen'">
        <tab-thuyen-chuyen
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
					:type-chuc-vu="$options.setting.typeThuyenChuyen"
        ></tab-thuyen-chuyen>
      </div>
      <div class="tab-pane" id="tab-bo-nhiem-khac" v-if="currentTab == 'bo_nhiem_khac'">
        <tab-bo-nhiem-khac
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
          :type-chuc-vu="$options.setting.typeBoNhiem"
        ></tab-bo-nhiem-khac>
      </div>
      <div class="tab-pane" id="tab-ho-so" v-if="currentTab == 'ho_so'">
        <tab-ho-so
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-ho-so>
      </div>
    </div>
  </form>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
} from 'store@admin/types/action-types'
import TabGeneral from './edits/TabGeneral'
import TabMoRong from './edits/TabMoRong'
import TabBangCap from './edits/TabBangCap'
import TabChucThanh from './edits/TabChucThanh'
import TabVanThu from './edits/TabVanThu'
import TabThuyenChuyen from './edits/TabThuyenChuyen'
import TabLmThuyenChuyen from './edits/TabLmThuyenChuyen'
import TabBoNhiemKhac from './edits/TabBoNhiemKhac'
import TabHoSo from './edits/TabHoSo'
import { fnCheckImgPath, } from '@app/common/util'

export default {
  name: 'FormEdit',
  components: {
    TabGeneral,
    TabMoRong,
    TabBangCap,
    TabChucThanh,
    TabVanThu,
    TabThuyenChuyen,
    TabLmThuyenChuyen,
    TabBoNhiemKhac,
    TabHoSo,
  },
  data() {
    const mm = new MM({
      el: '#modal-general-info-manager',
      api: this.$cmsCfg.mm.api,
      onSelect: (fi) => {
        if (fnCheckImgPath(fi, 'path')) {
          this.$data.imgSelected = `/${this.$cmsCfg.dirImage}/${fi.selected.path}`
          this.$data.selected = fi.selected
          document.getElementById('media-file-manager-content').style =
            'display:none'
        }
      },
    })

    return {
      fullPage: false,
      mm: mm,
      selected: null,
      imgSelected: '',
			currentTab: 'general',
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
      loading: (state) => state.loading,
      info: (state) => state.info,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK,
    ]),
    _submitInfo() {
      this[ACTION_INSERT_INFO](this.info)
    },
    _submitInfoBack() {
      this[ACTION_INSERT_INFO_BACK](this.info)
    },
  },
  setting: {
    typeBoNhiem: 1,
    typeThuyenChuyen: 0,
    typeKhac: 2,
    tab_general_title: 'Tổng quan',
    tab_mo_rong_title: 'Mở rộng',
    tab_bang_cap_title: 'Bằng Cấp',
    tab_chuc_thanh_title: 'Chức Thánh',
    tab_thuyen_chuyen_title: 'Thuyên Chuyển',
    tab_gp_thuyen_chuyen_title: 'LM.Thuyên Chuyển',
    tab_van_thu_title: 'Văn Thư',
    tab_special_info_title: 'Slide tin tức tiêu điểm',
    tab_bo_nhiem_khac_title: 'Bổ Nhiệm Khác',
    tab_ho_so_title: 'Hồ Sơ',
    error_msg_system: 'Lỗi hệ thống !',
    isForm: 'edit',
  },
}
</script>
