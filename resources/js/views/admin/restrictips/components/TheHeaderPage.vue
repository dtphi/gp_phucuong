<template>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <btn-add></btn-add>
        <button
          @click="_refreshList()"
          data-toggle="tooltip"
          :title="$options.setting.refresh_txt"
          class="btn btn-default"
          :data-original-title="$options.setting.refresh_txt"
        >
          <i class="fa fa-refresh"></i>
        </button>
        <button
          type="button"
          data-toggle="tooltip"
          title=""
          class="btn btn-danger"
          onclick="confirm('Are you sure?') ? $('#form-category').submit() : false;"
          data-original-title="Delete"
        >
          <i class="fa fa-trash-o"></i>
        </button>
      </div>
      <h1>{{ $options.setting.title }}</h1>
      <breadcrumb></breadcrumb>
      <ul class="cms-breadcrumb">
        <li>
          <perpage></perpage>
        </li>
        <li>
          <ul class="cms-breadcrumb">
            <li>
              <input
                v-model="query"
                type="text"
                class="form-control"
                placeholder="Search"
                aria-describedby="basic-addon2"
              />
            </li>
            <li>
              <button
                class="btn btn-primary btn-search"
                @click="preApiCall"
                @keyup.enter="preApiCall"
                type="button"
              >
                Search
              </button>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, mapMutations, } from 'vuex'
import BtnAdd from './TheBtnAdd'
import Perpage from 'com@admin/Pagination/SelectPerpage'
import Breadcrumb from 'com@admin/Breadcrumb'
import { MODULE_MODULE_RESTRICT_IP, } from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_SEARCH_ITEMS,
} from 'store@admin/types/action-types'
import { INFOS_SET_INFO_LIST, } from 'store@admin/types/mutation-types'
import { config, } from '@app/common/config'

export default {
  name: 'RestrictIpHeaderPage',
  components: {
    BtnAdd,
    Perpage,
    Breadcrumb,
  },
  data() {
    return {
      query: '',
      searchItemsSource: '',
    }
  },
  computed: {
    ...mapState({
      perPage: state => state.cfApp.perPage,
    }),
  },
  watch: {
    query: {
      handler: _.debounce(() => {
        this.preApiCall()
      }, 100),
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_RESTRICT_IP, {
      getInfoList: ACTION_GET_INFO_LIST,
      searchItems: ACTION_SEARCH_ITEMS,
    }),
    ...mapMutations(MODULE_MODULE_RESTRICT_IP, {
      setResIp: INFOS_SET_INFO_LIST,
    }),
    isBlank(str) {
      return !str || /^\s*$/.test(str)
    },
    _pushAddPage() {
      this.$router.push(`/${config.adminPrefix}/restrict-ips/add`)
    },
    _refreshList() {
      const params = {
        perPage: this.perPage,
      }
      this.getInfoList(params)
    },
    preApiCall() {
      this.apiCall(this.query)
    },
    apiCall(query) {
      if (!this.isBlank(query)) {
        this.searchItems(query)
      } else {
        this._refreshList()
      }
    },
  },
  setting: {
    title: 'Restrict Ip',
    refresh_txt: 'Tải lại danh sách',
  },
}
</script>
