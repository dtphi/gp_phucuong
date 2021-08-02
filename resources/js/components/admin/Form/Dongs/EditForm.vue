<template>
  <form class="form-horizontal">
    <!--<loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>-->
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tab-dong" data-toggle="tab">Dòng</a>
      </li>
    </ul>
    <!-- Tab General -->
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general">
        <tab-general role="tabpanel" class="tab-panel active"></tab-general>
      </div>
    </div>
  </form>
</template>

<script>
import { EventBus } from "@app/api/utils/event-bus";
import { mapState, mapGetters, mapActions } from "vuex";
import { MODULE_MODULE_DONG_EDIT } from "store@admin/types/module-types";
import {
  ACTION_SET_LOADING,
  ACTION_SET_IMAGE,
} from "store@admin/types/action-types";
import TabGeneral from "./edits/TabGeneral";

export default {
  name: "FormDongEdit",
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
    ...mapState(MODULE_MODULE_DONG_EDIT, {
      loading: (state) => state.loading,
      info: (state) => {
        return state.info;
      },
    }),
    ...mapGetters(MODULE_MODULE_DONG_EDIT, ["info"]),
  },
  created() {
    this.ACTION_GET_LIST_GIAO_PHAN({
      perPage: -1,
    });
  },
  mounted() {
    const _self = this;
    EventBus.$on("on-selected-image", (imgItem) => {
      _self.$data.file = imgItem;
      _self._selectMainImg(imgItem);
    });
  },
  methods: {
    ...mapActions(MODULE_MODULE_DONG_EDIT, [
      ACTION_SET_LOADING,
      ACTION_SET_IMAGE,
      "ACTION_UPDATE_INFO_DONG",
      "ACTION_UPDATE_INFO_DONG_BACK",
      "ACTION_GET_LIST_GIAO_PHAN",
    ]),
    _submitInfo() {
      this.ACTION_UPDATE_INFO_DONG(this.info);
    },
    _submitInfoBack() {
      this.ACTION_UPDATE_INFO_DONG_BACK(this.info);
    },
    _selectMainImg(file) {
      const image = {
        basename: "",
        dirname: "",
        extension: "",
        filename: "",
        path: "",
        size: 0,
        thumb: "",
        timestamp: "",
        type: "",
      };
      if (typeof file === "object") {
        let selected = image;

        if (file.hasOwnProperty("selected") && file.selected) {
          selected = file.selected;
        }

        this[ACTION_SET_IMAGE](selected);
      }
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
  },
};
</script>
