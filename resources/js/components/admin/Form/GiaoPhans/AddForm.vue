<template>
  <form class="form-horizontal">
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
        <a href="#tab-giao-hat" data-toggle="tab">Hạt</a>
      </li>

      <li>
        <a href="#tab-giao-hat-xu" data-toggle="tab">Giáo Xứ</a>
      </li>

      <li>
        <a href="#tab-giao-hat-congdoantusi" data-toggle="tab"
          >Công đoàn tu sĩ</a
        >
      </li>

      <li>
        <a href="#tab-dong-giao-phan" data-toggle="tab">Dòng</a>
      </li>

      <li>
        <a href="#tab-co-so-giao-phan" data-toggle="tab">Cơ sở</a>
      </li>

      <li>
        <a href="#tab-ban-chuyen-trach-giao-phan" data-toggle="tab"
          >Ban chuyên trách</a
        >
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general">
        <tab-general
          role="tabpanel"
          class="tab-pane active"
          :group-data="info"
        ></tab-general>
      </div>

      <div class="tab-pane" id="tab-giao-hat">
        <tab-giao-hat
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-giao-hat>
      </div>

      <div class="tab-pane" id="tab-giao-hat-xu">
        <tab-hat-xu
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-hat-xu>
      </div>

      <div class="tab-pane" id="tab-giao-hat-congdoantusi">
        <tab-hat-cong-doan-tu-si
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-hat-cong-doan-tu-si>
      </div>

      <div class="tab-pane" id="tab-dong-giao-phan">
        <tab-dong-giao-phan
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-dong-giao-phan>
      </div>

      <div class="tab-pane" id="tab-co-so-giao-phan">
        <tab-co-so-giao-phan
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-co-so-giao-phan>
      </div>

      <div class="tab-pane" id="tab-ban-chuyen-trach-giao-phan">
        <tab-ban-chuyen-trach-giao-phan
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-ban-chuyen-trach-giao-phan>
      </div>
    </div>
  </form>
</template>

<script>
import { EventBus, } from '@app/api/utils/event-bus'
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_PHAN_ADD, } from 'store@admin/types/module-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_SET_IMAGE,
  ACTION_INSERT_INFO_BACK,
} from 'store@admin/types/action-types'
import TabGeneral from './adds/TabGeneral'
import TabGiaoHat from './adds/TabHat'
import TabHatXu from './adds/TabHatXu'
import TabHatCongDoanTuSi from './adds/TabHatCongDoanTuSi'
import TabDongGiaoPhan from './adds/TabDongGiaoPhan'
import TabCoSoGiaoPhan from './adds/TabCoSoGiaoPhan'
import TabBanChuyenTrachGiaoPhan from './adds/TabBanChuyenTrachGiaoPhan'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'FormGiaoPhanAdd',
  components: {
    TabGeneral,
    TabGiaoHat,
    TabDongGiaoPhan,
    TabCoSoGiaoPhan,
    TabBanChuyenTrachGiaoPhan,
    TabHatXu,
    TabHatCongDoanTuSi,
  },
  data() {
    return {
      fullPage: false,
      file: null,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_PHAN_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_GIAO_PHAN_ADD, ['info']),
  },
  mounted() {
    const _self = this
    EventBus.$on('on-selected-image', (imgItem) => {
      _self.$data.file = imgItem
      _self._selectMainImg(imgItem)
    })
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, [
      ACTION_SET_LOADING,
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK,
      ACTION_SET_IMAGE
    ]),
    _submitInfo() {
      this[ACTION_INSERT_INFO](this.info)
    },
    _submitInfoBack() {
      this[ACTION_INSERT_INFO_BACK](this.info)
    },
    _selectMainImg(file) {
      const image = {
        basename: '',
        dirname: '',
        extension: '',
        filename: '',
        path: '',
        size: 0,
        thumb: '',
        timestamp: '',
        type: '',
      }
      if (typeof file === 'object') {
        let selected = image

        if (fnCheckProp(file, 'selected') && file.selected) {
          selected = file.selected
        }

        this[ACTION_SET_IMAGE](selected)
      }
    },
  },
  setting: {
    tab_general_title: 'Tổng quan',
    tab_mo_rong_title: 'Mở rộng',
    tab_bang_cap_title: 'Bằng Cấp',
    tab_chuc_thanh_title: 'Chức Thánh',
    tab_thuyen_chuyen_title: 'Thuyên Chuyển',
    tab_van_thu_title: 'Văn Thư',
    tab_special_info_title: 'Slide tin tức tiêu điểm',
    error_msg_system: 'Lỗi hệ thống !',
    isForm: 'add',
  },
}
</script>
