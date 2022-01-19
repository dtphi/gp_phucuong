<template>
  <div class="form-group">
    <label class="col-sm-2 control-label">
      <span data-toggle="tooltip" data-original-title="(Tự động hoàn toàn)"
        >Dong</span
      >
    </label>
    <div class="col-sm-10" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="name"
        type="text"
        name="dong-name"
        placeholder="Chọn dòng"
        id="input-parent-dong-name"
        class="form-control"
      />
      <input
        autocomplete="off"
        @keyup="_keyUpName"
        v-model="searchName"
        type="text"
        placeholder="Search tên"
        class="cms-btn-input-right" style="right:54px; border: 1px solid #ddd;width: 100px;"
      />
      <span class="btn btn-default cms-btn-input-right" @click="_closeDropdown">
        <i class="fa" :class="isSearch ? 'fa-search' : 'fa-close'"></i>
      </span>
      <ul v-show="!isSearch" class="dropdown-menu cms-ul-cate-dropdown">
        <li
          v-for="(item, idx) in _dongs"
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
  name: 'DongAutocomplete',
  props: {
    name: {
      default: null,
    },
  },
  data() {
    return {
      dropdownStyle: 'display: none;',
      isSearch: true,
      searchName: '',
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC, {
      dropdowns: (state) => state.dropdownDongs,
    }),
    _dongs() {
      if (this.searchName) {
        return _.filter(this.dropdowns, (obj) => {
          return obj.name.indexOf(this.searchName) !== -1
        })
      }

      return this.dropdowns
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC, ['ACTION_GET_DROPDOWN_DONG_LIST']),
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
      this.$emit('on-select-dong', infoCategory)
      this._closeDropdown()
    },
    _keyUpName(evt) {
      this.$data.searchName = evt.target.value
    },
  },
}
</script>
