<template>
  <form class="form-horizontal">
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tab-general" data-toggle="tab">{{
          $options.setting.tab_general_title
        }}</a>
      </li>
    </ul>
    <!-- tab general -->
    <div class="tab-content">
      <div class="tab-pane active" id="tab-general">
        <tab-general
          role="tabpanel"
          class="tab-panel active"
        >
        </tab-general>
      </div>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_RESTRICT_IP_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_SET_LOADING,
  ACTION_UPDATE_INFO,
  ACTION_UPDATE_INFO_BACK,
} from 'store@admin/types/action-types'
import TabGeneral from './edits/TabGeneral'

export default {
  name: 'FormRestrictIpEdit',
  components: {
    TabGeneral,
  },
  data() {
    return {
      fullPage: false,
      file: null,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_RESTRICT_IP_EDIT, {
      loading: (state) => state.loading,
      info:(state) => state.info.data,
    }),
    ...mapGetters(MODULE_MODULE_RESTRICT_IP_EDIT, ['info']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_RESTRICT_IP_EDIT, [
      ACTION_SET_LOADING,
      ACTION_UPDATE_INFO,
      ACTION_UPDATE_INFO_BACK
    ]),
    _submitInfo() {
      this[ACTION_UPDATE_INFO](this.info)
    },
    _submitInfoBack() {
      this[ACTION_UPDATE_INFO_BACK](this.info)
    },
  },
  setting: {
    tab_general_title: 'Tổng quan',
  },
}
</script>
