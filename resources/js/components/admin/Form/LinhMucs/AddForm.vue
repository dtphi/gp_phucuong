<template>
  <form class="form-horizontal" autocomplete="off">
    <!--<loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>-->
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tab-general" data-toggle="tab">{{
          $options.setting.tab_general_title
        }}</a>
      </li>
      <li>
        <a href="#tab-mo-rong" data-toggle="tab">{{
          $options.setting.tab_mo_rong_title
        }}</a>
      </li>
      <li>
        <a href="#tab-bang-cap" data-toggle="tab">{{
          $options.setting.tab_bang_cap_title
        }}</a>
      </li>
      <li>
        <a href="#tab-chuc-thanh" data-toggle="tab">{{
          $options.setting.tab_chuc_thanh_title
        }}</a>
      </li>
      <li>
        <a href="#tab-van-thu" data-toggle="tab">{{
          $options.setting.tab_van_thu_title
        }}</a>
      </li>
      <li>
        <a href="#tab-thuyen-chuyen" data-toggle="tab">{{
          $options.setting.tab_thuyen_chuyen_title
        }}</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general">
        <tab-general
          role="tabpanel"
          class="tab-pane active"
          :general-data="info"
          :mmSelected="selected"
          :mmPath="imgSelected"
        ></tab-general>
      </div>
      <div class="tab-pane" id="tab-mo-rong">
        <tab-mo-rong
          role="tabpanel"
          class="tab-pane"
          :general-data="info"
          :mmSelected="selected"
          :mmPath="imgSelected"
        ></tab-mo-rong>
      </div>
      <div class="tab-pane" id="tab-bang-cap">
        <tab-bang-cap
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-bang-cap>
      </div>
      <div class="tab-pane" id="tab-chuc-thanh">
        <tab-chuc-thanh
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-chuc-thanh>
      </div>
      <div class="tab-pane" id="tab-van-thu">
        <tab-van-thu
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-van-thu>
      </div>
      <div class="tab-pane" id="tab-thuyen-chuyen">
        <tab-thuyen-chuyen
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-thuyen-chuyen>
      </div>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_LINH_MUC_ADD, } from 'store@admin/types/module-types'
import {
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
} from 'store@admin/types/action-types'
import TabGeneral from './adds/TabGeneral'
import TabMoRong from './adds/TabMoRong'
import TabBangCap from './adds/TabBangCap'
import TabChucThanh from './adds/TabChucThanh'
import TabVanThu from './adds/TabVanThu'
import TabThuyenChuyen from './adds/TabThuyenChuyen'
import { fnCheckImgPath, } from '@app/common/util'
import { config, } from '@app/common/config'

export default {
  name: 'FormAdd',
  components: {
    TabGeneral,
    TabMoRong,
    TabBangCap,
    TabChucThanh,
    TabVanThu,
    TabThuyenChuyen,
  },
  data() {
    const mm = new MM({
      el: '#modal-general-info-manager',
      api: config.mm.api,
      onSelect: (fi) => {
        if (fnCheckImgPath(fi, 'path')) {
          this.$data.imgSelected = `/${config.dirImage}/${fi.selected.path}`
          this.$data.selected = fi.selected
          document.getElementById('media-file-manager-content').style =
            'display:none'
        }
      },
    })

    return {
      fullPage: false,
      file: null,
      mm: mm,
      selected: null,
      imgSelected: '',
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_LINH_MUC_ADD, ['info']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_ADD, [
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK
    ]),
    _submitInfo() {
      this[ACTION_INSERT_INFO](this.info)
    },
    _submitInfoBack() {
      this[ACTION_INSERT_INFO_BACK](this.info)
    },
  },
  setting: {
    tab_general_title: 'Tổng quan',
    tab_mo_rong_title: 'Mở rộng',
    tab_bang_cap_title: 'Bằng Cấp',
    tab_chuc_thanh_title: 'Chức Thánh',
    tab_thuyen_chuyen_title: 'Thuyên Chuyển',
    tab_van_thu_title: 'Văn Thư',
    error_msg_system: 'Lỗi hệ thống !',
  },
}
</script>
