<template>
  <form class="form-horizontal">
    <!--<loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>-->
    <ul class="nav nav-tabs">
      <li>
        <a href="#tab-giao-hat-xu" data-toggle="tab">Giáo Xứ</a>
      </li>
    </ul>
    <div class="tab-content">
      <!-- TAB GENERAL -->
      <div class="tab-pane active" id="tab-giao-hat-xu">
        <tab-general
          role="tabpanel"
          class="tab-pane active"
          :media="mm"
        ></tab-general>
      </div>
    </div>
  </form>
</template>

<script>
import TabGeneral from './adds/TabGeneral'
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_XU_ADD, } from 'store@admin/types/module-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_SET_IMAGE,
  ACTION_INSERT_INFO_BACK,
} from 'store@admin/types/action-types'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'FormGiaoXuAdd',
  components: {
    TabGeneral,
  },
  data() {
    const mm = new MM({
      el: '#modal-general-info-manager',
      api: {
        baseUrl: window.origin + '/api/mmedia',
        listUrl: 'list',
        uploadUrl: 'upload',
      },
      onSelect: function(fi) {
        if (typeof fi === 'object') {
          if (fnCheckProp(fi, 'selected') && fi.selected) {
            const pathImg = '/Image/NewPicture/'

            if (fnCheckProp(fi.selected, 'path')) {
              if (this._selfCom.fn) {
                this._selfCom.fn(pathImg + fi.selected.path, fi.selected)
              } else {
                if (typeof this._selfCom[ACTION_SET_IMAGE] == 'function') {
                  this._selfCom[ACTION_SET_IMAGE](pathImg + fi.selected.path)
                }
              }

              document.getElementById('media-file-manager-content').style =
                'display:none'
            }
          }
        }
      },
      _selfCom: null,
    })

    return {
      fullPage: false,
      file: null,
      mm: mm,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_XU_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_GIAO_XU_ADD, ['info']),
  },
  /* Create list giao hat */
  created() {
    this.ACTION_GET_LIST_GIAO_HAT({
      perPage: -1,
    })
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_XU_ADD, [
      ACTION_SET_LOADING,
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK,
      ACTION_SET_IMAGE,
      'ACTION_GET_LIST_GIAO_HAT',
      'ACTION_INSERT_INFO_GIAOXU'
    ]),
    _submitInfo() {
      this.ACTION_INSERT_INFO_GIAOXU(this.info)
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
    tab_special_info_title: 'Slide tin tức tiêu điểm',
    error_msg_system: 'Lỗi hệ thống !',
    isForm: 'add',
  },
}
</script>
