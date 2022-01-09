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
                        <th style="width: 1px" class="text-left">No</th>
                        <th style="width: 1px" class="text-center">
                          <input
                            type="checkbox"
                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"
                          />
                        </th>
                        <th style="width: 100px" class="text-left">Linh mục</th>
                        <th style="width: 200px" class="text-left">
                          Từ giáo xứ
                        </th>
                        <th style="width: 200px" class="text-left">Chức vụ</th>
                        <th style="width: 200px" class="text-left">Từ ngày</th>
                        <th style="width: 200px" class="text-left">Đức cha</th>
                        <th style="width: 200px" class="text-left">
                          Đến giáo xứ
                        </th>
                        <th style="width: 200px" class="text-left">Đến ngày</th>
                        <th style="width: 200px" class="text-left" colspan="2">Chức vụ</th>
                        <th style="width: 100px" class="text-right">Action</th>
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
    <modal
      name="modal-linh-muc-thuyen-chuyen-edit"
      :height="455"
      :click-to-close="false"
    >
      <the-modal-edit
        v-if="_infoUpdate.id"
        :info="_infoUpdate"
        @update-info-success="_updateInfoList"
        @change-form="_changeForm"
      ></the-modal-edit>
    </modal>
    <the-modal-add></the-modal-add>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import Item from './components/TheItem'
import TheHeaderPage from './components/TheHeaderPage'
import Paginate from 'com@admin/Pagination'
import {
  MODULE_MODULE_THUYEN_CHUYEN,
  MODULE_MODULE_THUYEN_CHUYEN_EDIT,
} from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import TheModalAdd from './components/TheModalAdd'
import TheModalEdit from './components/TheModalEdit'

export default {
  name: 'DanhSachLinhMucThuyenChuyen',
  components: {
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
    }
  },
  watch: {
    isDelete(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  computed: {
    ...mapState({
      perPage: state => state.cfApp.perPage,
    }),
    ...mapGetters(['isNotEmptyList']),
    ...mapState(MODULE_MODULE_THUYEN_CHUYEN, ['infos', 'loading', 'isDelete']),
    ...mapState(MODULE_MODULE_THUYEN_CHUYEN_EDIT, ['info']),
    _infoList() {
      return this.infos
    },
    _notEmpty() {
      return this.isNotEmptyList
    },
    _infoUpdate() {
      return this.infoUpdate
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_THUYEN_CHUYEN, {
      getInfoList: ACTION_GET_INFO_LIST,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    _showModalAdd() {
      this.$modal.show('modal-linh-muc-thuyen-chuyen-add')
    },
    _showModalEdit(info) {
      this.curInfo = info
      this.infoUpdate = { ...info, }
      this.$modal.show('modal-linh-muc-thuyen-chuyen-edit')
    },
    _updateInfoList() {
      this.curInfo.from_giao_xu_id = this.info.from_giao_xu_id
      this.curInfo.from_chuc_vu_id = this.info.from_chuc_vu_id
      this.curInfo.from_date = this.info.from_date
      this.curInfo.duc_cha_id = this.info.duc_cha_id
      this.curInfo.to_date = this.info.to_date
      this.curInfo.chuc_vu_id = this.info.chuc_vu_id
      this.curInfo.giao_xu_id = this.info.giao_xu_id
      this.curInfo.co_so_gp_id = this.info.co_so_gp_id
      this.curInfo.dong_id = this.info.dong_id
      this.curInfo.ban_chuyen_trach_id = this.info.ban_chuyen_trach_id
      this.curInfo.du_hoc = this.info.du_hoc
      this.curInfo.quoc_gia = this.info.quoc_gia
      this.curInfo.ghi_chu = this.info.ghi_chu
      this.curInfo.active = this.info.active
      this.$modal.hide('modal-linh-muc-thuyen-chuyen-edit')
    },
    _changeForm(info) {
      switch (info.type) {
      case 'from.giao.xu': {
        this.infoUpdate.fromGiaoXuName = info.name
        this.infoUpdate.from_giao_xu_id = info.id
        break
      }
      case 'from.chuc.vu': {
        this.infoUpdate.fromchucvuName = info.name
        this.infoUpdate.from_chuc_vu_id = info.id
        break
      }
      case 'from.duc.cha': {
        this.infoUpdate.ducchaName = info.name
        this.infoUpdate.duc_cha_id = info.id
        break
      }
      case 'to.chuc.vu': {
        this.infoUpdate.chucvuName = info.name
        this.infoUpdate.chuc_vu_id = info.id
        break
      }
      case 'to.giao.xu': {
        this.infoUpdate.giaoxuName = info.name
        this.infoUpdate.giao_xu_id = info.id
        break
      }
      case 'co.so.giao.phan': {
        this.infoUpdate.cosogpName = info.name
        this.infoUpdate.co_so_gp_id = info.id
        break
      }
      case 'dong': {
        this.infoUpdate.dongName = info.name
        this.infoUpdate.dong_id = info.id
        break
      }
      case 'ban.chuyen.trach': {
        this.infoUpdate.banchuyentrachName = info.name
        this.infoUpdate.ban_chuyen_trach_id = info.id
        break
      }
      }
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification()
    },
  },
  mounted() {
    const params = {
      perPage: this.perPage,
    }
    this.getInfoList(params)
  },
  setting: {
    list_title: 'Danh sách thuyên chuyển',
  },
}
</script>
