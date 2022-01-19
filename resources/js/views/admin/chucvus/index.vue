<template>
  <div id="content">
    <the-header-page @show-modal-add="_showModalAdd"></the-header-page>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            <i class="fa fa-list"></i> {{ $options.setting.list_title }}
          </h3>
          <div class="row" id="cms-panel-search">
            <div class="col-sm-3">
              <input class="form-control" type="text" placeholder="Tên chức vụ" v-model="searchs.name"/>
            </div>
            <div class="col-sm-3">
              <select class="form-control" v-model="searchs.type_giao_xu">
                <option value="-1"></option>
                <option
                  :selected="item.type_giao_xu == idx"
                  :value="idx"
                  v-for="(item, idx) in $cmsCfg.loaiChucVus"
                  :key="idx"
                >
                  {{ item }}
                </option>
              </select>
            </div>
            <div class="col-sm-3">
              <select class="form-control" v-model="searchs.active">
                <option value="-1"></option>
                <option value="1" >Xảy ra</option>
                <option value="0" >Ẩn</option>
              </select>
            </div>
            <div class="col-sm-3">
              <button class="btn btn-primary" @click="_searchList"><i class="fa fa-search"></i>Tìm kiếm</button>
            </div>
          </div>
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
                        <th style="width: 1%" class="text-left">No</th>
                        <th style="width: 1%" class="text-center">
                          <input
                            type="checkbox"
                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"
                          />
                        </th>
                        <th style="width: 30%" class="text-left">
                          Tên chức vụ
                        </th>
                        <th style="width: 30%" class="text-left">
                          Loại chức vụ
                        </th>
                        <th style="width: 10%">Sắp xếp</th>
                        <th style="width: 10%;" class="text-center">Trạng thái</th>
                        <th style="width: 15%" class="text-right">Action</th>
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
    <the-modal-edit @update-info-success="_updateInfoList"></the-modal-edit>
    <the-modal-add @add-info-success="_addInfoList"></the-modal-add>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import Item from './components/TheItem'
import TheHeaderPage from './components/TheHeaderPage'
import Paginate from 'com@admin/Pagination'
import { MODULE_MODULE_CHUC_VU, MODULE_MODULE_CHUC_VU_EDIT, } from 'store@admin/types/module-types'
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
      searchs: {
        name: '',
        type_giao_xu: -1,
        active: -1,
        page: 1,
      }
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
      rootData: (state) => state.cfApp,
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
      ACTION_RESET_NOTIFICATION_INFO,
    ]),
    ...mapActions(MODULE_MODULE_CHUC_VU_EDIT, [
      'ACTION_RESET_INFO_ITEM'
    ]),
    _showModalAdd() {
      this.$modal.show('modal-chuc-vu-add')
    },
    _addInfoList() {
      this.$modal.hide('modal-chuc-vu-add')
      const params = {
        ...this.rootData.searchs,
        perPage: this.rootData.perPage,
      }
      this[ACTION_GET_INFO_LIST](params)
    },
    _showModalEdit() {
      this.$modal.show('modal-chuc-vu-edit')
    },
    async _updateInfoList() {
      this.$modal.hide('modal-chuc-vu-edit')
      const params = {
        ...this.rootData.searchs,
        perPage: this.rootData.perPage,
      }
      await this[ACTION_GET_INFO_LIST](params)
      await this.ACTION_RESET_INFO_ITEM()
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this[ACTION_RESET_NOTIFICATION_INFO]()
    },
    _searchList() {
      const params = {
        ...this.searchs,
        perPage: this.rootData.perPage,
      }
      this.$store.dispatch('updateSearch', params)
      this[ACTION_GET_INFO_LIST](params)
    }
  },
  mounted() {
    const params = {
      perPage: this.rootData.perPage,
    }
    this[ACTION_GET_INFO_LIST](params)
  },
  setting: {
    list_title: 'Danh sách chức vụ',
  },
}
</script>
