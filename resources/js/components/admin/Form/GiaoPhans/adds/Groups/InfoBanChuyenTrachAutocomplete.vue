<template>
  <div class="form-group">
    <label
      class="col-sm-1 control-label"
      for="input-parent-ban-chuyen-trach-name"
    >
      <span
        data-toggle="tooltip"
        data-original-title="(Tự động hoàn toàn)"
      ></span>
    </label>
    <div class="col-sm-11" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="banChuyenTrach.banChuyenTrachName"
        type="text"
        name="category"
        placeholder="Chọn ban chuyên trách"
        id="input-parent-ban-chuyen-trach-name"
        class="form-control"
      />
      <span class="btn btn-default cms-btn-input-right" @click="_closeDropdown">
        <i class="fa" :class="isSearch ? 'fa-search' : 'fa-close'"></i>
      </span>
      <ul v-show="!isSearch" class="dropdown-menu cms-ul-cate-dropdown">
        <li
          v-for="(item, idx) in dropdowns"
          :key="idx"
          @click="_addInfoToCategory(item)"
        >
          <a href="javascript:void(0);">{{ item.name }}</a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import {
  MODULE_MODULE_LINH_MUC,
  MODULE_MODULE_GIAO_PHAN_ADD,
} from 'store@admin/types/module-types'

export default {
  name: 'InfoBanChuyenTrachAutocomplete',
  props: {
    banChuyenTrach: {
      default: null,
    },
  },
  data() {
    return {
      dropdownStyle: 'display: none;',
      isSearch: true,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC, {
      dropdowns: (state) => state.dropdownBanChuyenTrachs,
    }),
    ...mapState(MODULE_MODULE_GIAO_PHAN_ADD, ['info']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC, [
      'ACTION_GET_DROPDOWN_BAN_CHUYEN_TRACH_LIST'
    ]),
    ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, [
      'ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST'
    ]),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.ACTION_GET_DROPDOWN_BAN_CHUYEN_TRACH_LIST(query)
      }
    },
    _focusParentCategory() {
      if (this.dropdowns.length == 0) {
        this.ACTION_GET_DROPDOWN_BAN_CHUYEN_TRACH_LIST('')
      }
    },
    _closeDropdown() {
      this.isSearch = !this.isSearch
      this._focusParentCategory()
    },
    _addInfoToCategory(infoCategory) {
      const _self = this
      const isExist = _.find(_self.info.giao_phan_banchuyentrachs, {
        ban_chuyen_trach_id: infoCategory.id,
      })

      if (isExist === undefined) {
        this.ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST({
          banChuyenTrach: _self.banChuyenTrach,
          banChuyenTrachInfo: infoCategory,
        })
      }

      this._closeDropdown()
    },
  },
}
</script>
