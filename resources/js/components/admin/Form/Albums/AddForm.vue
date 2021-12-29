<template>
  <form class="form-horizontal">
    <loading-over-lay
      :active.sync="loading"
      :is-full-page="fullPage"
    ></loading-over-lay>
    <ul class="nav nav-tabs">
      <li>
        <a href="#tab-albums" data-toggle="tab">Tổng quan</a>
      </li>
      <li>
        <a href="#tab-media-manager" data-toggle="tab">Ảnh đại diện</a>
      </li>
      <li>
        <a href="#tab-albums-image" data-toggle="tab">Danh sách hình ảnh</a>
      </li>
    </ul>
    <div class="tab-content">
      <!-- TAB GENERAL -->
      <div class="tab-pane active" id="tab-albums">
        <tab-general
          role="tabpanel"
          class="tab-pane active"
          :group-data="info"
        ></tab-general>
      </div>
      <!-- ORIGIN IMAGE -->
      <div class="tab-pane" id="tab-media-manager">
        <tab-media-manager
          ref="mediaManagerTab"
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-media-manager>
      </div>
      <!-- TAB ALBUMS IMAGES -->
      <div class="tab-pane" id="tab-albums-image">
        <tab-albums-image role="tabpanel" class="tab-pane"></tab-albums-image>
      </div>
    </div>
  </form>
</template>

<script>
import TabGeneral from './adds/TabGeneral'
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_ALBUMS_ADD, } from 'store@admin/types/module-types'
import TabAlbumsImage from './TabAlbumsImage'
import { EventBus, } from '@app/api/utils/event-bus'
import TabMediaManager from './TabImage'
import { fnCheckProp, } from '@app/common/util'

import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_SET_IMAGE,
  ACTION_INSERT_INFO_BACK,
  ACTION_GET_INFO_LIST,
} from 'store@admin/types/action-types'

export default {
  name: 'FormAlbumsAdd',
  components: {
    TabGeneral,
    TabAlbumsImage,
    TabMediaManager,
  },
  data() {
    return {
      fullPage: false,
      file: null,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_ALBUMS_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_ALBUMS_ADD, ['info']),
  },
  /* Create list group albums */
  created() {
    this.ACTION_GET_LIST_GROUP_ALBUMS({
      perPage: -1,
    })
  },
  mounted() {
    const _self = this
    EventBus.$on('on-selected-image', (imgItem) => {
      _self.$data.file = imgItem
      _self._selectMainImg(imgItem)
    })
  },
  methods: {
    ...mapActions(MODULE_MODULE_ALBUMS_ADD, [
      ACTION_SET_LOADING,
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK,
      ACTION_SET_IMAGE,
      ACTION_GET_INFO_LIST,
      'ACTION_GET_LIST_GROUP_ALBUMS'
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
