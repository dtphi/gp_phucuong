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
      <!--  <li>
                <a
                    href="#tab-special-info"
                    data-toggle="tab">{{$options.setting.tab_special_info_title}}</a>
            </li> -->
    </ul>
    <!-- Add Form GiaoPhanTinTuc Page -->
    <div class="tab-content">
      <!-- Tab General -->
      <div class="tab-pane active" id="tab-general">
        <tab-general
          role="tabpanel"
          class="tab-pane active"
          :general-data="info"
        ></tab-general>
      </div>
      <!-- Tab Advanced -->
      <div class="tab-pane" id="tab-advance">
        <tab-advance
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-advance>
      </div>
      <!-- Tab Link -->
      <div class="tab-pane" id="tab-link">
        <tab-link
          role="tabpanel"
          class="tab-pane"
          :is-form="$options.setting.isForm"
          :group-data="info"
        ></tab-link>
      </div>
      <!-- Tab Media -->
      <div class="tab-pane" id="tab-media-manager">
        <tab-media-manager
          ref="mediaManagerTab"
          role="tabpanel"
          class="tab-pane"
          :group-data="info"
        ></tab-media-manager>
      </div>

      <!-- <div class="tab-pane" id="tab-special-info">
                <tab-special-info-carousel
                    role="tabpanel"
                    class="tab-pane"></tab-special-info-carousel>
            </div> -->
    </div>
  </form>
</template>

<script>
import { EventBus, } from '@app/api/utils/event-bus'
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_TINTUC_GIAOPHAN_ADD, } from 'store@admin/types/module-types'
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
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'FormAddGiaoPhanTinTuc',
  components: {
    TabGeneral,
    TabAdvance,
    TabLink,
    TabMediaManager,
    /* TabSpecialInfoCarousel, */
  },
  data() {
    return {
      fullPage: false,
      file: null,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_TINTUC_GIAOPHAN_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_TINTUC_GIAOPHAN_ADD, ['info']),
  },
  mounted() {
    const _self = this
    EventBus.$on('on-selected-image', (imgItem) => {
      _self.$data.file = imgItem
      _self._selectMainImg(imgItem)
    })
  },
  methods: {
    ...mapActions(MODULE_MODULE_TINTUC_GIAOPHAN_ADD, [
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
