<template>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button
          @click="_redirectUrl()"
          data-toggle="tooltip"
          title=""
          class="btn btn-primary"
          data-original-title="Thêm Nhóm Tin"
        >
          <i class="fa fa-plus"></i>
        </button>
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
        <li><perpage></perpage></li>
        <li><list-search></list-search></li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import Perpage from 'com@admin/Pagination/SelectPerpage'
import ListSearch from 'com@admin/Search'
import Breadcrumb from 'com@admin/Breadcrumb'
import { MODULE_MODULE_DANHMUC_GIAOPHAN, } from 'store@admin/types/module-types'
import { ACTION_GET_NEWS_GROUP_LIST, } from 'store@admin/types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'GiaoPhanDanhMucHeaderPage',
  components: {
    Perpage,
    ListSearch,
    Breadcrumb,
  },
  methods: {
    ...mapActions(MODULE_MODULE_DANHMUC_GIAOPHAN, [ACTION_GET_NEWS_GROUP_LIST]),
    _pushAddPage() {
      this.$router.push(`/${this.$cmsCfg.adminPrefix}/giao-phan/danh-mucs/add`)
    },
    _refreshList() {
      this[ACTION_GET_NEWS_GROUP_LIST]()
    },
    _redirectUrl() {
      return fn_redirect_url(`${this.$cmsCfg.adminPrefix}/giao-phan/danh-mucs/add`)
    },
  },
  setting: {
    title: 'Danh Mục Tin',
    refresh_txt: 'Tải lại danh sách',
  },
}
</script>
