<template>
  <div class="form-group">
    <label class="col-sm-1 control-label" for="input-parent-dong-name">
      <span
        data-toggle="tooltip"
        data-original-title="(Tự động hoàn toàn)"
      ></span>
    </label>
    <div class="col-sm-11" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="dong.dongName"
        type="text"
        name="category"
        placeholder="Chọn dòng"
        id="input-parent-dong-name"
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
  MODULE_MODULE_GIAO_PHAN_EDIT,
} from 'store@admin/types/module-types'

export default {
  name: 'DongAutocomplete',
  props: {
    dong: {
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
      dropdowns: (state) => state.dropdownDongs,
    }),
    ...mapState(MODULE_MODULE_GIAO_PHAN_EDIT, ['info']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC, ['ACTION_GET_DROPDOWN_DONG_LIST']),
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      'ACTION_UPDATE_DROPDOWN_DONG_LIST'
    ]),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.ACTION_GET_DROPDOWN_DONG_LIST(query)
      }
    },
    _focusParentCategory() {
      if (this.dropdowns.length == 0) {
        this.ACTION_GET_DROPDOWN_DONG_LIST('')
      }
    },
    _closeDropdown() {
      this.isSearch = !this.isSearch
      this._focusParentCategory()
    },
    _addInfoToCategory(infoCategory) {
      const _self = this
      const isExistDong = _.find(_self.info.giao_phan_dongs, {
        dong_id: infoCategory.id,
      })

      if (isExistDong === undefined) {
        this.ACTION_UPDATE_DROPDOWN_DONG_LIST({
          dong: _self.dong,
          dongInfo: infoCategory,
        })
      }

      this._closeDropdown()
    },
  },
}
</script>
