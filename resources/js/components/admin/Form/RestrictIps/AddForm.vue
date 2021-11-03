<template>
  <form class="form-horizontal">
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
import { MODULE_MODULE_RESTRICT_IP_ADD } from "store@admin/types/module-types";
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
} from "store@admin/types/action-types";

export default {
  name: "FormRestrictIpAdd",
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
    ...mapState(MODULE_MODULE_RESTRICT_IP_ADD, {
      loading: (state) => state.loading,
    }),
    ...mapGetters(MODULE_MODULE_RESTRICT_IP_ADD, ["info"]),
  },
  methods: {
    ...mapActions(MODULE_MODULE_RESTRICT_IP_ADD, [
      ACTION_SET_LOADING,
      ACTION_INSERT_INFO,
      ACTION_INSERT_INFO_BACK,
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
    isForm: "add",
  },
};
</script>
