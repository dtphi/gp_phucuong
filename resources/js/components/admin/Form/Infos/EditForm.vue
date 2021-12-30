<template>
  <form class="form-horizontal">
    <loading-over-lay
      :active.sync="loading"
      :is-full-page="fullPage"
    ></loading-over-lay>
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tab-general" data-toggle="tab">{{
          $options.setting.tab_general_title
        }}</a>
      </li>
      <li>
        <a href="#tab-advance" data-toggle="tab">{{
          $options.setting.tab_advance_title
        }}</a>
      </li>
      <li>
        <a href="#tab-link" data-toggle="tab">{{
          $options.setting.tab_link_title
        }}</a>
      </li>
      <li>
        <a href="#tab-media-manager" data-toggle="tab">{{
          $options.setting.tab_image_title
        }}</a>
      </li>
      <li>
        <a href="#tab-special-info" data-toggle="tab">{{
          $options.setting.tab_special_info_title
        }}</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general">
        <tab-general
          role="tabpanel"
          class="tab-pane active"
          :general-data="info"
        ></tab-general>
      </div>

      <div class="tab-pane" id="tab-advance">
        <tab-advance
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-advance>
      </div>

      <div class="tab-pane" id="tab-link">
        <tab-link
          role="tabpanel"
          class="tab-pane"
          :is-form="$options.setting.isForm"
          :group-data="info"
        ></tab-link>
      </div>

      <div class="tab-pane" id="tab-media-manager">
        <tab-media-manager
          ref="mediaManagerTab"
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-media-manager>
      </div>

      <div class="tab-pane" id="tab-special-info">
        <tab-special-info-carousel
          role="tabpanel"
          class="tab-pane"
        ></tab-special-info-carousel>
      </div>
    </div>
  </form>
</template>

<script>
import TabSpecialInfoCarousel from './TabSpecialInfoCarousel'
import { OnSelectedImage, } from '@app/api/utils/event-bus'
import { mapState, mapGetters, mapActions, } from 'vuex'
import {
  MODULE_INFO_EDIT,
  MODULE_MODULE_SPECIAL_INFO_CAROUSEL,
} from 'store@admin/types/module-types'
import {
  ACTION_UPDATE_INFO,
  ACTION_SET_IMAGE,
  ACTION_GET_SETTING,
} from 'store@admin/types/action-types'
import TabGeneral from './TabGeneral'
import TabAdvance from './TabAdvance'
import TabLink from './TabLink'
import TabMediaManager from './TabImage'
import { fnCheckImgSelect, } from '@app/common/util'

export default {
  name: 'InformationEditForm',
  components: {
    TabSpecialInfoCarousel,
    TabGeneral,
    TabMediaManager,
    TabAdvance,
    TabLink,
  },
  data() {
    return {
      fullPage: false,
      file: null,
    }
  },
  computed: {
    ...mapState(MODULE_INFO_EDIT, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_INFO_EDIT, ['info']),
  },
  watch: {
    'info.special_carousels'(newValue) {
      if (newValue) {
        this._setInfoCarousel(newValue)
      }
    },
  },
  created() {
    OnSelectedImage((imgItem) => {
      this.$data.file = imgItem
      this._selectMainImg(imgItem)
    })
  },
  methods: {
    ...mapActions(MODULE_MODULE_SPECIAL_INFO_CAROUSEL, [ACTION_GET_SETTING]),
    ...mapActions(MODULE_INFO_EDIT, [ACTION_UPDATE_INFO, ACTION_SET_IMAGE]),
    _getInfo() {
      return this.$deep(this.info)
    },
    _submitInfo() {
      this[ACTION_UPDATE_INFO](this._getInfo())
    },
    _selectMainImg(file) {
      if (typeof file === 'object') {
        this[ACTION_SET_IMAGE](
          fnCheckImgSelect(file) ? file.selected : this.$options.setting.imgObj
        )
      }
    },
    _setInfoCarousel() {
      const carousel = this.$deep(this.info.special_carousels)
      this[ACTION_GET_SETTING](carousel)
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
