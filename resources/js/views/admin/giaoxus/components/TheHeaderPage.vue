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
        <li v-if="giaoHatLists">
            <model-select
              :options="giaoHatLists"
              v-model="giaoHat"
              placeholder="Chọn Giáo Hạt"
            ></model-select>
        </li>
        <li>
          <list-search></list-search>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import BtnAdd from './TheBtnAdd'
import Perpage from 'com@admin/Pagination/SelectPerpage'
import ListSearch from 'com@admin/Search'
import Breadcrumb from 'com@admin/Breadcrumb'
import { MODULE_MODULE_GIAO_XU, } from 'store@admin/types/module-types'
import { ACTION_GET_INFO_LIST, ACTION_GET_INFO_BY_ID, ACTION_GET_LIST_GIAO_HAT } from 'store@admin/types/action-types'
import { ModelSelect } from 'vue-search-select'
export default {
  name: 'GiaoXuHeaderPage',
  components: {
    BtnAdd,
    Perpage,
    ListSearch,
    Breadcrumb,
    ModelSelect,
  },
  data() {
    return {
      giaoHat: '',
      id_refresh: -1,
    }
  },
  watch: {
    giaoHat() {
      this.getInfoList({idGiaoHat: this.giaoHat});
    }
  },
  computed: {
    ...mapState({
      perPage: state => state.cfApp.perPage,
    }),
    ...mapState(MODULE_MODULE_GIAO_XU, {
      giaoHatLists: state => state.giaoHatLists,
      idGiaoHat: state => state.idGiaoHat,
    })
  },
  created() {
    this.getListGiaoHat();
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_XU, {
      getInfoList: ACTION_GET_INFO_LIST,
      getGiaoXuByGiaoHat: ACTION_GET_INFO_BY_ID,
      getListGiaoHat: ACTION_GET_LIST_GIAO_HAT,
    }),
    _pushAddPage() {
      this.$router.push(`/${this.$cmsCfg.adminPrefix}/giao-xus/add`)
    },
    _refreshList() {
      this.giaoHat = ''
      this.getInfoList({idGiaoHat: this.id_refresh})
    },
  },
  setting: {
    title: 'Giáo xứ',
    refresh_txt: 'Tải lại danh sách',
  },
}
</script>
