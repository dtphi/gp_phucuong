<template>
  <form class="form-horizontal">
    <!--<loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>-->
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tab-giao-hat-xu" data-toggle="tab">Giáo Xứ</a>
      </li>
    </ul>
    <!-- Tab General -->
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general">
        <tab-general
          ref="tabGeneral"
          role="tabpanel"
          class="tab-panel active"
          :media="mm"
          :mmSelected="selected"
          :mmPath="imgSelected"
        ></tab-general>
      </div>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_XU_EDIT, } from 'store@admin/types/module-types'
import TabGeneral from './edits/TabGeneral'
import {
  ACTION_SET_LOADING,
  ACTION_UPDATE_INFO,
  ACTION_UPDATE_INFO_BACK,
} from 'store@admin/types/action-types'
import { fnCheckImgPath, } from '@app/common/util'
import { config, } from '@app/common/config'

export default {
  name: 'FormGiaoXuEdit',
  components: {
    TabGeneral,
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
      mm: mm,
      selected: null,
      imgSelected: '',
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_XU_EDIT, {
      loading: (state) => state.loading,
      info: (state) => state.info,
    }),
    ...mapGetters(MODULE_MODULE_GIAO_XU_EDIT, ['info']),
  },
  created() {
    this.ACTION_GET_LIST_GIAO_HAT({
      perPage: -1,
    })
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_XU_EDIT, [
      ACTION_SET_LOADING,
      ACTION_UPDATE_INFO,
      ACTION_UPDATE_INFO_BACK,
      'ACTION_GET_LIST_GIAO_HAT'
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
