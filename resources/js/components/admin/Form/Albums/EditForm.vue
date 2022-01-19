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
import TabAlbumsImage from './TabAlbumsImage'
import { OnSelectedImage, } from '@app/api/utils/event-bus'
import { mapState, mapGetters, mapActions, } from 'vuex'
import {
  MODULE_MODULE_ALBUMS_EDIT,
  MODULE_MODULE_ALBUMS_ADD,
} from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_INFO,
  ACTION_SET_IMAGE,
  ACTION_GET_SETTING,
} from 'store@admin/types/action-types'
import TabGeneral from './edits/TabGeneral'
import TabMediaManager from './TabImage'
import { fnCheckImgSelect, } from '@app/common/util'

export default {
  name: 'InformationEditForm',
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
    ...mapState(MODULE_MODULE_ALBUMS_EDIT, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_ALBUMS_EDIT, ['info']),
  },
  watch: {
    'info.group_images'(newValue) {
      if (newValue) {
        this._setInfoCarousel(newValue)
      }
    },
  },
  created() {
    this.ACTION_GET_LIST_GROUP_ALBUMS({
      perPage: -1,
    })
    OnSelectedImage((imgItem) => {
      this.$data.file = imgItem
      this._selectMainImg(imgItem)
    })
  },
  methods: {
    ...mapActions(MODULE_MODULE_ALBUMS_ADD, [
      ACTION_GET_SETTING,
      'ACTION_GET_LIST_GROUP_ALBUMS'
    ]),
    ...mapActions(MODULE_MODULE_ALBUMS_EDIT, [
      ACTION_UPDATE_INFO,
      ACTION_SET_IMAGE
    ]),
    _submitInfo() {
      this[ACTION_UPDATE_INFO](this.info)
    },
    _selectMainImg(file) {
      if (typeof file === 'object') {
        this[ACTION_SET_IMAGE](
          fnCheckImgSelect(file) ? file.selected : this.$options.setting.imgObj
        )
      }
    },
    _setInfoCarousel() {
      this[ACTION_GET_SETTING](this.info.group_images)
    },
  },
  setting: {
    imgObj: {
      basename: '',
      dirname: '',
      extension: '',
      filename: '',
      path: '',
      size: 0,
      thumb: '',
      timestamp: '',
      type: '',
    },
    btnSubmitTxt: 'Update',
    tab_general_title: 'Tổng quan',
    tab_advance_title: 'Mở rộng',
    tab_image_title: 'Hình ảnh',
    tab_link_title: 'Liên kết',
    tab_design_title: 'Màn hình',
    error_msg_system: 'Lỗi hệ thống !',
    isForm: 'edit',
    tab_special_info_title: 'Slide tin tức tiêu điểm',
  },
}
</script>
