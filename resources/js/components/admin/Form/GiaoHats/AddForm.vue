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
    <div class="tab-content">
      <!-- TAB GENERAL -->
      <div class="tab-pane active" id="tab-general">
        <tab-general role="tabpanel" class="tab-pane active" :group-data="info">
        </tab-general>
      </div>
    </div>
  </form>
</template>

<script>
import TabGeneral from "./adds/TabGeneral";
import { mapState, mapGetters, mapActions } from "vuex";
import { MODULE_MODULE_GIAO_HAT_ADD } from "store@admin/types/module-types";
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
} from "store@admin/types/action-types";


export default {
  name: "FormGiaoHatAdd",
  components: {
    TabGeneral,
  },
  data() {
    return {
      fullPage: false,
      file: null,
    };
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_HAT_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_GIAO_HAT_ADD, ["info"]),
  },
  created(){
    this.action_get_list_linh_muc();
    console.log(this.action_get_list_linh_muc());
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_HAT_ADD, [
      ACTION_SET_LOADING,
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK,
      'action_get_list_linh_muc',
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
    isForm: "add",
  },
};
</script>
