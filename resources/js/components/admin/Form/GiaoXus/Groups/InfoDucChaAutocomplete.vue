<template>
  <div class="form-group">
    <label class="col-sm-2 control-label">
      <span data-toggle="tooltip" data-original-title="(Tự động hoàn toàn)"
        >Đức cha</span
      >
    </label>
    <div class="col-sm-10" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="name"
        type="text"
        name="category"
        placeholder="Chọn đức cha"
        id="input-parent-duc-cha-name"
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
  name: 'InfoDucChaAutocomplete',
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
      dropdowns: (state) => state.dropdownDucChas,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC, ['ACTION_GET_DROPDOWN_DUC_CHA_LIST']),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.ACTION_GET_DROPDOWN_DUC_CHA_LIST(query)
      }
    },
    _focusParentCategory() {
      if (this.dropdowns.length == 0) {
        this.ACTION_GET_DROPDOWN_DUC_CHA_LIST('')
      }
    },
    _closeDropdown() {
      this.isSearch = !this.isSearch
      this._focusParentCategory()
    },
    _addInfoToCategory(infoCategory) {
      this.$emit('on-select-chuc-cha', infoCategory)
      this._closeDropdown()
    },
  },
}
</script>
