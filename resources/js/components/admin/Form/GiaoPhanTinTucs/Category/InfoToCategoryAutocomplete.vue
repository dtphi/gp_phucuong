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
        v-model="query"
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
      <ul class="dropdown-menu cms-ul-cate-dropdown" :style="dropdownStyle">
        <!--<li>
                    <span class="btn btn-default cms-btn-dropdown" @click="_closeDropdown">
                        <font-awesome-layers size="2x" style="background:MistyRose">
                            <font-awesome-icon icon="circle" style="color:Tomato"/>
                            <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                        </font-awesome-layers>
                    </span>
                </li>-->
        <the-dropdown-category
          :key="-1"
          :category="itemNone"
        ></the-dropdown-category>

        <the-dropdown-category
          v-for="(item, idx) in dropdowns"
          :key="idx"
          :category="item"
        ></the-dropdown-category>
      </ul>

      <div
        v-if="categorys.length"
        key="category-result-list"
        class="well well-sm"
        style="height: 150px; overflow: auto"
      >
        <category-item
          v-for="(item, idx) in categorys"
          :key="idx"
          :info-to-category="item"
        ></category-item>
      </div>
      <div
        v-else
        key="category-result-empty"
        class="well well-sm"
        style="height: 150px; overflow: auto"
      ></div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import TheDropdownCategory from './DropdownInfoToCategoryAutocomplete'
import CategoryItem from './CategoryItem'
import {
  MODULE_MODULE_DANHMUC_GIAOPHAN,
  MODULE_MODULE_DANHMUC_GIAOPHAN_EDIT,
  MODULE_MODULE_TINTUC_GIAOPHAN_ADD,
} from 'store@admin/types/module-types'
import {
  ACTION_GET_DROPDOWN_CATEGORY_LIST,
  ACTION_ADD_INFO_TO_CATEGORY_LIST,
} from 'store@admin/types/action-types'

export default {
  name: 'CategoryEditAutocomplete',
  components: {
    TheDropdownCategory,
    CategoryItem,
  },
  props: {
    categoryId: {
      default: null,
    },
  },
  data() {
    return {
      dropdownStyle: 'display: none;',
      itemNone: {
        category_id: -1,
        name: ' --- Chọn --- ',
        sort_order: 0,
      },
      query: '',
    }
  },
  computed: {
    ...mapGetters(MODULE_MODULE_DANHMUC_GIAOPHAN_EDIT, [
      'infoCategory',
      'getNameQuery'
    ]),
    ...mapState(MODULE_MODULE_TINTUC_GIAOPHAN_ADD, {
      categorys: (state) => state.listCategorysDisplay,
    }),
    ...mapState(MODULE_MODULE_DANHMUC_GIAOPHAN, {
      dropdowns: (state) => state.dropdownCategories,
    }),
  },
  watch: {
    query: {
      handler: _.debounce(function() {
        this._searchCategories()
      }, 100),
    },
    infoCategory: {
      handler: function() {
        this._addInfoToCategory(this.infoCategory)
      },
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_DANHMUC_GIAOPHAN, [
      ACTION_GET_DROPDOWN_CATEGORY_LIST
    ]),
    ...mapActions(MODULE_MODULE_TINTUC_GIAOPHAN_ADD, [
      ACTION_ADD_INFO_TO_CATEGORY_LIST
    ]),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this[ACTION_GET_DROPDOWN_CATEGORY_LIST](query)
      }
    },
    _focusParentCategory() {
      const query = this.query
      this[ACTION_GET_DROPDOWN_CATEGORY_LIST](query)
      this.$data.dropdownStyle = 'display:block'
    },
    _closeDropdown() {
      this.$data.dropdownStyle = 'display:none'
    },
    _addInfoToCategory(infoCategory) {
      this[ACTION_ADD_INFO_TO_CATEGORY_LIST](infoCategory)
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
.cms-ul-cate-dropdown > li > a:hover,
.cms-dropdown-menu > li > a:focus {
  background-color: green !important;
}
.cms-btn-dropdown {
  position: absolute;
  right: 0px;
  top: 0px;
  font-size: 0.5em;
}
</style>
