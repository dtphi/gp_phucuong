<template>
  <div class="form-group">
    <label class="col-sm-2 control-label">
      <span data-toggle="tooltip" data-original-title="(Tự động hoàn toàn)"
        >Cơ sở giáo phận</span
      >
    </label>
    <div class="col-sm-10" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="name"
        type="text"
        name="category"
        placeholder="Chọn cơ sở giáo phận"
        id="input-parent-co-so-giao-phan-name"
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
  name: 'GiaoXuAutocomplete',
  props: {
    name: {
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
      dropdowns: (state) => state.dropdownCoSoGiaoPhans,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC, [
      'ACTION_GET_DROPDOWN_CO_SO_GIAO_PHAN_LIST'
    ]),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.ACTION_GET_DROPDOWN_CO_SO_GIAO_PHAN_LIST(query)
      }
    },
    _focusParentCategory() {
      if (this.dropdowns.length == 0) {
        this.ACTION_GET_DROPDOWN_CO_SO_GIAO_PHAN_LIST('')
      }
    },
    _closeDropdown() {
      this.isSearch = !this.isSearch
      this._focusParentCategory()
    },
    _addInfoToCategory(infoCategory) {
      this.$emit('on-select-co-so-giao-phan', infoCategory)
      this._closeDropdown()
    },
  },
}
</script>
