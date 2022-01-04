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
                        <th style="width: 200px" class="text-left">
                          Tên chức vụ
                        </th>
                        <th style="width: 100px" class="text-left">
                          Loại chức vụ
                        </th>
                        <th>Sắp xếp</th>
                        <th>Văn thư bổ nhiệm</th>
                        <th class="text-center">Trạng thái</th>
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
    <modal name="modal-chuc-vu-edit" :height="455" :click-to-close="false">
      <the-modal-edit
        @update-info-success="_updateInfoList"
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
  MODULE_MODULE_CHUC_VU,
} from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import TheModalAdd from './components/TheModalAdd'
import TheModalEdit from './components/TheModalEdit'

export default {
  name: 'DanhSachChucVu',
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
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapGetters(['isNotEmptyList']),
    ...mapState(MODULE_MODULE_CHUC_VU, ['infos', 'loading', 'isDelete']),
    _infoList() {
      return this.infos
    },
    _notEmpty() {
      return this.isNotEmptyList
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_CHUC_VU, [
      ACTION_GET_INFO_LIST,
      ACTION_RESET_NOTIFICATION_INFO
    ]),
    _showModalAdd() {
      this.$modal.show('modal-chuc-vu-add')
    },
    _showModalEdit() {
      this.$modal.show('modal-chuc-vu-edit')
    },
    _updateInfoList() {
      this.$modal.hide('modal-chuc-vu-edit')
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this[ACTION_RESET_NOTIFICATION_INFO]()
    },
  },
  mounted() {
    const params = {
      perPage: this.perPage,
    }
    this[ACTION_GET_INFO_LIST](params)
  },
  setting: {
    list_title: 'Danh sách chức vụ',
  },
}
</script>
