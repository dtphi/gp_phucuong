<template>
  <div class="form-group">
    <label class="col-sm-2 control-label">
      <span data-toggle="tooltip" data-original-title="(Tự động hoàn toàn)"
        >Tên thánh</span
      >
    </label>
    <div class="col-sm-10" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="tenThanh"
        type="text"
        placeholder="Chọn tên thánh"
        id="input-parent-ten-thanh-name"
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
import { MODULE_MODULE_LINH_MUC, } from 'store@admin/types/module-types'

export default {
  name: 'InfoTenThanhAutocomplete',
  props: {
    tenThanh: {
      default: '',
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
      dropdowns: (state) => state.dropdownThanhs,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC, [
      'ACTION_GET_DROPDOWN_TEN_THANH_LIST'
    ]),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.ACTION_GET_DROPDOWN_TEN_THANH_LIST(query)
      }
    },
    _focusParentCategory() {
      if (this.dropdowns.length == 0) {
        this.ACTION_GET_DROPDOWN_TEN_THANH_LIST('')
      }
    },
    _closeDropdown() {
      this.isSearch = !this.isSearch
      this._focusParentCategory()
    },
    _addInfoToCategory(infoCategory) {
      this.$emit('on-select-ten-thanh', infoCategory)
      this._closeDropdown()
    },
  },
}
</script>
