<template>
  <div id="content">
    <the-header-page></the-header-page>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            <i class="fa fa-list"></i> {{ $options.setting.list_title }}
          </h3>
          <div class="row cms-panel-search">
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Tên linh mục" v-model="searchs.name"/>
            </div>
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Phone" v-model="searchs.phone"/>
            </div>
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Email" v-model="searchs.email"/>
            </div>
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Ngày sinh" v-model="searchs.ngay_sinh"/>
            </div>
            <div class="col-sm-2">
              <select class="form-control" v-model="searchs.trieu_dong">
                <option value="-1"></option>
                <option
                  :value="idx"
                  v-for="(item, idx) in $cmsCfg.trieuDongs"
                  :key="idx"
                >
                  {{ item }}
                </option>
              </select>
            </div>
            <div class="col-sm-2 text-right">
              <button class="btn btn-primary" @click="_searchList"><i class="fa fa-search"></i>Tìm kiếm</button>
            </div>
          </div>
          <div class="row cms-panel-search">
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Nơi sinh" v-model="searchs.noi_sinh"/>
            </div>
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Nơi rửa tội" v-model="searchs.noi_rua_toi"/>
            </div>
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Nơi thêm sức" v-model="searchs.noi_them_suc"/>
            </div>
            <div class="col-sm-2">
              <input class="form-control" type="text" placeholder="Số Cmnd" v-model="searchs.cmnd"/>
            </div>
            <div class="col-sm-2">
              <select class="form-control" v-model="searchs.active">
                <option value="-1"></option>
                <option value="1" >Xảy ra</option>
                <option value="0" >Ẩn</option>
              </select>
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
                        <th style="width: 5%" class="text-left">No</th>
                        <th style="width: 5%" class="text-center">
                          <input
                            type="checkbox"
                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"
                          />
                        </th>
                        <th style="width: 20%" class="text-left">Tên</th>
                        <th style="width: 10%" class="text-left">Hình ảnh</th>
                        <th style="width: 10%" class="text-left">Phone</th>
                        <th style="width: 10%" class="text-left">Email</th>
                        <th style="width: 10%" class="text-center">
                          Sinh ngày
                        </th>
                        <th style="width: 10%" class="text-center">
                          Triệu dòng
                        </th>
                        <th style="width: 10%" class="text-center">
                          Trạng thái
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
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import Item from './components/TheItem'
import TheHeaderPage from './components/TheHeaderPage'
import Paginate from 'com@admin/Pagination'
import { MODULE_MODULE_LINH_MUC, } from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'

export default {
  name: 'InformationList',
  components: {
    TheHeaderPage,
    Item,
    Paginate,
  },
  data() {
    return {
      fullPage: false,
      isResource: false,
      searchs: {
        name: '',
        phone: '',
        email: '',
        ngay_sinh: '',
        trieu_dong: -1,
        noi_sinh: '',
        noi_rua_toi: '',
        noi_them_suc: '',
        cmnd: '',
        active: -1,
      }
    }
  },
  watch: {
    updateSuccess(newValue) {
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
    ...mapState(MODULE_MODULE_LINH_MUC, ['infos', 'loading', 'updateSuccess']),
    _infoList() {
      return this.infos
    },
    _notEmpty() {
      return this.isNotEmptyList
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC, {
      getInfoList: ACTION_GET_INFO_LIST,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    _submitAction(event) {
      this[event.target.value]({
        action: event.target.value,
      })
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification()
    },
    _searchList() {
      const params = {
        ...this.searchs,
        perPage: this.rootData.perPage,
      }
      this.$store.dispatch('updateSearch', params)
      this.getInfoList(params)
    }
  },
  mounted() {
    const params = {
      perPage: this.rootData.perPage,
    }
    this.getInfoList(params)
  },
  setting: {
    list_title: 'Danh sách Linh mục',
  },
}
</script>

<style scoped lang="scss">
.cms-panel-search {
  margin-bottom: 5px;
}
</style>