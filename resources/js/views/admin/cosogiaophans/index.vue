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
                        <th style="width: 5%" class="text-left">No</th>
                        <!-- <th style="width: 1px" class="text-center">
                          <input
                            type="checkbox"
                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"
                          />
                        </th> -->
                        <th style="width: 10%" class="text-left">Tên</th>
                        <th style="width: 25%" class="text-left">Địa chỉ</th>
                        <th style="witdh: 15%" class="text-center">Email</th>
                        <th style="witdh: 15%" class="text-center">Điện thoại</th>
                        <th style="witdh: 15%" class="text-center">Website</th>
                        <th style="witdh: 10%" class="text-center">Cơ sở</th>
                        <th style="width: 5%" class="text-right">Action</th>
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
    <modal name="modal-co-so-edit" :height="455" :click-to-close="false">
      <the-modal-edit
        @update-info-success="_updateInfoList"
      ></the-modal-edit>
    </modal>
    <the-modal-add @add-info-success="_addInfoList"></the-modal-add>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import Item from './components/TheItem'
import TheHeaderPage from './components/TheHeaderPage'
import Paginate from 'com@admin/Pagination'
import {
  MODULE_MODULE_CO_SO,
  MODULE_MODULE_CO_SO_EDIT
} from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import TheModalAdd from './components/TheModalAdd'
import TheModalEdit from './components/TheModalEdit'

export default {
  name: 'DanhSachCoSo',
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
      curInfo: {}
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
      rootData: (state) => state.cfApp,
    }),
    ...mapGetters(['isNotEmptyList']),
    ...mapState(MODULE_MODULE_CO_SO, ['infos', 'loading', 'isDelete']),
    ...mapState(MODULE_MODULE_CO_SO_EDIT, ['info']),
    _infoList() {
      return this.infos
    },
    _notEmpty() {
      return this.isNotEmptyList
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_CO_SO, {
      getInfoList: ACTION_GET_INFO_LIST,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    ...mapActions(MODULE_MODULE_CO_SO_EDIT, ['ACTION_RESET_INFO_ITEM']),
    _showModalAdd() {
      this.$modal.show('modal-co-so-add')
    },
    _addInfoList() {
      this.$modal.hide('modal-co-so-add')
      const params = {
        ...this.rootData.searchs,
        perPage: this.rootData.perPage
      }
      this[ACTION_GET_INFO_LIST](params)
    },
    _showModalEdit() {
      this.$modal.show('modal-co-so-edit')
    },
    async _updateInfoList() {
      this.$modal.hide('modal-co-so-edit')
      const params = {
        ...this.rootData.searchs,
        perPage: this.rootData.perPage,
      }
      await this.getInfoList(params)
      await this.ACTION_RESET_INFO_ITEM()
      
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
    list_title: 'Danh sách cơ sở',
  },
}
</script>
