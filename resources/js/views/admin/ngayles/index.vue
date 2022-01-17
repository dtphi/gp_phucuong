<template>
  <div id="content">
    <the-header-page @show-modal-add="_showModalAdd"></the-header-page>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            <i class="fa fa-list"></i> {{ $options.setting.list_title }}
          </h3>
        </div>
        <div class="panel-body">
          <div id="form-category">
            <div class="table-responsive">
              <template v-if="loading">
                <loading-over-lay
                  :active.sync="loading"
                  :is-full-page="fullPage"
                ></loading-over-lay>
              </template>
              <template v-if="_infoList">
                <div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr role="row">
                        <!-- title table -->
                        <th style="width: 3%" class="text-left">ID</th>
                        <th style="width: 10%" class="text-left">Code</th>
                        <th style="width: 20%" class="text-center">Tên Lễ</th>
                        <th style="width: 15%" class="text-center">
                          Solar Day
                        </th>
                        <th style="width: 15%" class="text-center">
                          Solar Month
                        </th>
                        <th style="width: 15%" class="text-center">
                          Lunar Day
                        </th>
                        <th style="width: 15%" class="text-right">
                          Lunar Month
                        </th>
                        <th style="width: 10%" class="text-right">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <item
                        v-for="(item, index) in _infoList"
                        :info="item"
                        :no="index"
                        :key="item.id"
                        @show-modal-edit="_showModalEdit"
                      ></item>
                    </tbody>
                  </table>
                </div>
              </template>
            </div>
            <paginate :is-resource="isResource"></paginate>
          </div>
        </div>
      </div>
    </div>
    <modal name="modal-ngay-le-edit" :height="555" :click-to-close="false">
      <the-modal-edit
        v-if="_infoUpdate.id"
        :info="_infoUpdate"
        :info-id="_infoUpdate.id"
        @update-info-success="_updateInfoList"
      ></the-modal-edit>
    </modal>
    <the-modal-add></the-modal-add>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import Item from "./components/TheItem";
import TheHeaderPage from "./components/TheHeaderPage";
import Breadcrumb from "com@admin/Breadcrumb";
import Paginate from "com@admin/Pagination";
import {
  MODULE_MODULE_NGAY_LE,
  MODULE_MODULE_NGAY_LE_EDIT,
} from "store@admin/types/module-types";
import {
  ACTION_GET_INFO_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from "store@admin/types/action-types";
import TheModalAdd from "./components/TheModalAdd";
import TheModalEdit from "./components/TheModalEdit";
import { config } from "@app/common/config";

export default {
  name: "DanhSachNgayLe",
  components: {
    Breadcrumb,
    TheHeaderPage,
    Item,
    Paginate,
    TheModalAdd,
    TheModalEdit,
  },
  data() {
    return {
      fullPage: false,
      isResource: false,
      infoUpdate: {},
      curInfo: {},
    };
  },
  watch: {
    'isDelete'(newValue, oldValue) {
      if (newValue) {
        this._notificationUpdate(newValue);
      }
    },
  },
  computed: {
    ...mapState({
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapGetters(["isNotEmptyList"]),
    ...mapState(MODULE_MODULE_NGAY_LE, [
      'infos',
       'loading',
        'isDelete']),
    ...mapState(MODULE_MODULE_NGAY_LE_EDIT, ["info"]),
    _infoList() {
      return this.infos;
    },
    _notEmpty() {
      return this.isNotEmptyList;
    },
    _infoUpdate() {
      return this.infoUpdate
    }
  },
  methods: {
    ...mapActions(MODULE_MODULE_NGAY_LE, {
      'getInfoList': ACTION_GET_INFO_LIST,
      'resetNotification': ACTION_RESET_NOTIFICATION_INFO,
    }),
    _showModalAdd() {
      this.$modal.show("modal-ngay-le-add");
    },
    _showModalEdit(info) {
      this.curInfo = info;
      this.infoUpdate = { ...info };
      this.$modal.show("modal-ngay-le-edit");
    },
    _updateInfoList() {
      this.curInfo.code = this.info.code;
      this.curInfo.ten_le = this.info.ten_le;
      this.curInfo.solar_day = this.info.solar_day;
      this.curInfo.solar_month = this.info.solar_month;
      this.curInfo.lunar_day = this.info.lunar_day;
      this.curInfo.lunar_month = this.info.lunar_month;
      this.curInfo.loai_le = this.info.loai_le;
      this.curInfo.bac_le = this.info.bac_le;
      this.curInfo.hanh = this.info.hanh;
      this.curInfo.nam_ai = this.info.nam_ai;
      this.curInfo.nam_aii = this.info.nam_aii;
      this.curInfo.nam_bi = this.info.nam_bi;
      this.curInfo.nam_bii = this.info.nam_bii;
      this.curInfo.nam_ci = this.info.nam_ci;
      this.curInfo.nam_cii = this.info.nam_cii;

      this.$modal.hide("modal-ngay-le-edit");
    },
    _notificationUpdate(notification) {
      this.$notify(notification);
      this.resetNotification();
    },
  },
  mounted() {
    const params = {
      perPage: this.perPage,
    };
    this.getInfoList(params);
  },
  setting: {
    cf: config,
    list_title: "Danh sách Ngày Lễ",
  },
};
</script>