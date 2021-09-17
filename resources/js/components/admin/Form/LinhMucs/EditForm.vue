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
          :media="mm"
        ></tab-general>
      </div>
      <div class="tab-pane" id="tab-mo-rong">
        <tab-mo-rong
          role="tabpanel"
          class="tab-pane"
          :general-data="info"
          :media="mm"
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
import { mapState, mapActions } from "vuex";
import { MODULE_MODULE_LINH_MUC_EDIT } from "store@admin/types/module-types";
import {
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE
} from "store@admin/types/action-types";
import TabGeneral from "./edits/TabGeneral";
import TabMoRong from "./edits/TabMoRong";
import TabBangCap from "./edits/TabBangCap";
import TabChucThanh from "./edits/TabChucThanh";
import TabVanThu from "./edits/TabVanThu";
import TabThuyenChuyen from "./edits/TabThuyenChuyen";

export default {
  name: "FormEdit",
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
        api: {
            baseUrl: window.origin + '/api/mmedia',
            listUrl: 'list',
            uploadUrl: 'upload',
        },
        onSelect: function (fi) {
            if (typeof fi === "object") {
                if (fi.hasOwnProperty('selected') && fi.selected) {
                    const pathImg = 'Image/NewPicture/';

                    if (fi.selected.hasOwnProperty('path')) {
                        if (this._selfCom.fn) {
                            this._selfCom.fn(pathImg + fi.selected.path, fi.selected);
                        } else {
                          if (typeof this._selfCom.[ACTION_SET_IMAGE] == "function"){
                            this._selfCom.[ACTION_SET_IMAGE](pathImg + fi.selected.path);
                          }
                        }

                        document.getElementById('media-file-manager-content').style = "display:none";
                    }
                }
            }
        },
        _selfCom: null
    })
    
    return {
      fullPage: false,
      mm: mm
    };
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
      loading: (state) => state.loading,
      info: (state) => state.info,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK
    ]),
    _submitInfo() {
      this[ACTION_INSERT_INFO](this.info);
    },
    _submitInfoBack() {
      this[ACTION_INSERT_INFO_BACK](this.info);
    },
  },
  setting: {
    tab_general_title: "Tổng quan",
    tab_mo_rong_title: "Mở rộng",
    tab_bang_cap_title: "Bằng Cấp",
    tab_chuc_thanh_title: "Chức Thánh",
    tab_thuyen_chuyen_title: "Thuyên Chuyển",
    tab_van_thu_title: "Văn Thư",
    tab_special_info_title: "Slide tin tức tiêu điểm",
    error_msg_system: "Lỗi hệ thống !",
    isForm: "edit",
  }
};
</script>
