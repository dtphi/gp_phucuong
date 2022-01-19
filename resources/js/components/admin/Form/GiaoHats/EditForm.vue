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
    </ul>
    <!-- tab geneal -->
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general">
        <tab-general
          role="tabpanel"
          class="tab-panel active"
        >
        </tab-general>
      </div>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_HAT_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_SET_LOADING,
  ACTION_UPDATE_INFO,
  ACTION_SET_IMAGE,
  ACTION_UPDATE_INFO_BACK,
} from 'store@admin/types/action-types'
import TabGeneral from './edits/TabGeneral'

export default {
  name: 'FormGiaoHatEdit',
  components: {
    TabGeneral,
  },
  data() {
    return {
      fullPage: false,
      file: null,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_HAT_EDIT, {
      loading: (state) => state.loading,
      info:(state) => state.info.data,
    }),
    ...mapGetters(MODULE_MODULE_GIAO_HAT_EDIT, ['info']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_HAT_EDIT, [
      ACTION_SET_LOADING,
      ACTION_UPDATE_INFO,
      ACTION_UPDATE_INFO_BACK,
      ACTION_SET_IMAGE
    ]),
    _submitInfo() {
      this[ACTION_UPDATE_INFO](this.info)
    },
    _submitInfoBack() {
      this[ACTION_UPDATE_INFO_BACK](this.info)
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
    isForm: 'edit',
  },
}
</script>
