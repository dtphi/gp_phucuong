<template>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="input-parent-category-name">
      <span data-toggle="tooltip" data-original-title="(Tự động hoàn toàn)">{{
        $options.setting.paren_category_txt
      }}</span>
    </label>
    <div class="col-sm-10" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        v-on:keyup.enter="_searchProducts()"
        v-model="newsGroupAdd.nameQuery"
        type="text"
        name="category"
        :placeholder="$options.setting.paren_category_txt"
        id="input-parent-category-name"
        class="form-control"
      />
      <span class="btn btn-default cms-btn-input-right" @click="_closeDropdown">
        <font-awesome-layers size="2x" style="background: MistyRose">
          <font-awesome-icon icon="circle" style="color: Tomato" />
          <font-awesome-icon
            icon="times"
            class="fa-inverse"
            transform="shrink-4"
          />
        </font-awesome-layers>
      </span>
      <ul
        class="dropdown-menu cms-dropdown-menu cms-ul-cate-dropdown"
        :style="dropdownStyle"
      >
        <the-dropdown-category
          :key="-1"
          :category="itemNone"
        ></the-dropdown-category>

        <the-dropdown-category
          v-for="(item, idx) in dropdownCategories"
          :key="idx"
          :category="item"
        ></the-dropdown-category>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState, } from 'vuex'
import TheDropdownCategory from './TheDropdownDanhMucs'
import {
  MODULE_MODULE_DANHMUC_GIAOPHAN,
  MODULE_MODULE_DANHMUC_GIAOPHAN_ADD,
} from 'store@admin/types/module-types'
import { ACTION_GET_DROPDOWN_CATEGORY_LIST, } from 'store@admin/types/action-types'

export default {
  name: 'CategoryAutocomplete',
  components: { TheDropdownCategory, },
  props: {
    categoryId: {
      default: 0,
    },
  },
  data() {
    return {
      dropdownStyle: 'display: none;',
      itemNone: {
        category_id: 0,
        category_name: ' --- Chọn --- ',
        sort_order: 0,
      },
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_DANHMUC_GIAOPHAN, ['dropdownCategories']),
    ...mapGetters(MODULE_MODULE_DANHMUC_GIAOPHAN_ADD, ['newsGroupAdd']),
  },
  watch: {
    'newsGroupAdd.nameQuery': {
      handler: _.debounce(function() {
        this._searchProducts()
      }, 100),
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_DANHMUC_GIAOPHAN, [ACTION_GET_DROPDOWN_CATEGORY_LIST]),
    _searchProducts() {
      const query = this.newsGroupAdd.nameQuery
      if (query && query.length) {
        this[ACTION_GET_DROPDOWN_CATEGORY_LIST]('')
      }
    },
    _focusParentCategory() {
      this[ACTION_GET_DROPDOWN_CATEGORY_LIST]('')
      this.$data.dropdownStyle = 'display:block'
    },
    _closeDropdown() {
      this.$data.dropdownStyle = 'display:none'
    },
  },
  setting: {
    paren_category_txt: 'Danh mục tin tức cha',
  },
}
</script>

<style type="text/css" lang="css" scoped>
.cms-ul-cate-dropdown {
  top: 35px;
  left: 15px;
}
.cms-btn-dropdown {
  position: absolute;
  right: 0px;
  top: 0px;
  font-size: 0.5em;
}
.cms-dropdown-menu > li > a:hover,
.cms-dropdown-menu > li > a:focus {
  background-color: green !important;
}
</style>
