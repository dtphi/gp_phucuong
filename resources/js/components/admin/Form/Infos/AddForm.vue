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
          :media="mm"
          :mmSelected="selected"
          :mmPath="imgSelected"
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
import { OnSelectedImage, } from '@app/api/utils/event-bus'
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_INFO_ADD, } from 'store@admin/types/module-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_SET_IMAGE,
  ACTION_INSERT_INFO_BACK,
} from 'store@admin/types/action-types'
import TabGeneral from './TabGeneral'
import TabAdvance from './TabAdvance'
import TabLink from './TabLink'
import TabMediaManager from './TabImage'
import TabSpecialInfoCarousel from './TabSpecialInfoCarousel'
import { fnCheckImgSelect, fnCheckImgPath, } from '@app/common/util'

export default {
  name: 'FormAdd',
  components: {
    TabGeneral,
    TabAdvance,
    TabLink,
    TabMediaManager,
    TabSpecialInfoCarousel,
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
      file: null,
      mm: mm,
      selected: null,
      imgSelected: '',
    }
  },
  computed: {
    ...mapState(MODULE_INFO_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_INFO_ADD, ['info']),
  },
  created() {
    OnSelectedImage((imgItem) => {
      this.$data.file = imgItem
      this._selectMainImg(imgItem)
    })
  },
  methods: {
    ...mapActions(MODULE_INFO_ADD, [
      ACTION_SET_LOADING,
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK,
      ACTION_SET_IMAGE
    ]),
    _getInfo() {
      return this.$deep(this.info)
    },
    _submitInfo() {
      this[ACTION_INSERT_INFO](this._getInfo())
    },
    _submitInfoBack() {
      this[ACTION_INSERT_INFO_BACK](this._getInfo())
    },
    _selectMainImg(file) {
      if (typeof file === 'object') {
        this[ACTION_SET_IMAGE](
          fnCheckImgSelect(file) ? file.selected : this.$options.setting.imgObj
        )
      }
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
    tab_general_title: 'Tổng quan',
    tab_advance_title: 'Mở rộng',
    tab_link_title: 'Liên kết',
    tab_image_title: 'Hình ảnh',
    tab_design_title: 'Màn hình',
    tab_special_info_title: 'Slide tin tức tiêu điểm',
    error_msg_system: 'Lỗi hệ thống !',
    isForm: 'add',
  },
}
</script>
