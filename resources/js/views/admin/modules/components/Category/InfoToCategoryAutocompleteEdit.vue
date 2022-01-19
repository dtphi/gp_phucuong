<template>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="input-parent-category-name">
      <span data-toggle="tooltip" data-original-title="(Tự động hoàn toàn)"
        >Danh mục</span
      >
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
        <the-dropdown-category
          :key="-1"
          :category="itemNone"
          :select-dropdown-category-item="_selectCategory"
        ></the-dropdown-category>
        <the-dropdown-category
          v-for="(item, idx) in dropdowns"
          :key="idx"
          :category="item"
          :select-dropdown-category-item="_selectCategory"
        ></the-dropdown-category>
      </ul>
      <div
        v-if="categorys.length"
        key="module-category-results"
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
        key="module-category-results"
        class="well well-sm"
        style="height: 150px; overflow: auto"
      ></div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import TheDropdownCategory from './DropdownInfoToCategoryAutocomplete'
import CategoryItem from './CategoryItemEdit'
import {
  MODULE_NEWS_CATEGORY,
  MODULE_INFO_EDIT,
} from 'store@admin/types/module-types'
import {
  ACTION_GET_DROPDOWN_CATEGORY_LIST,
  ACTION_ADD_INFO_TO_CATEGORY_LIST,
} from 'store@admin/types/action-types'

export default {
  name: 'TheCategoryAutocompleteList',
  components: {
    TheDropdownCategory,
    CategoryItem,
  },
  props: {
    infoCategory: Object,
    getNameQuery: String,
    settingCategory: Object,
    dropdownCategory: [Object, Array],
    resetSettingCategory: Function,
    selectCategory: Function,
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
    ...mapState(MODULE_INFO_EDIT, {
      categorys: state => state.listCategorysDisplay,
      categoryIds: state => state.info.categorys,
    }),
    ...mapState(MODULE_NEWS_CATEGORY, {
      dropdowns: (state) => state.dropdownCategories,
    }),
  },
  watch: {
    query: {
      handler: _.debounce(() => {
        this._searchCategories()
      }, 100),
    },
    infoCategory: {
      handler: function() {
        this._addInfoToCategory(this.infoCategory)
      },
    },
    categoryIds(newValue) {
      this.resetSettingCategory(newValue)
    },
    dropdownCategory(newValue) {
      this._initAddCategoryModule(newValue)
    },
  },
  methods: {
    ...mapActions(MODULE_NEWS_CATEGORY, {
      moduleGetDropdownCategoryList: ACTION_GET_DROPDOWN_CATEGORY_LIST,
    }),
    ...mapActions(MODULE_INFO_EDIT, {
      moduleAddInfoToCategoryList: ACTION_ADD_INFO_TO_CATEGORY_LIST,
    }),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.moduleGetDropdownCategoryList(query)
      }
    },
    _focusParentCategory() {
      const query = this.query
      this.moduleGetDropdownCategoryList(query)
      this.$data.dropdownStyle = 'display:block'
    },
    _closeDropdown() {
      this.$data.dropdownStyle = 'display:none'
    },
    _addInfoToCategory(infoCategory) {
      this.moduleAddInfoToCategoryList(infoCategory)
    },
    _initAddCategoryModule(cateList) {
      _.forEach(this.settingCategory.value, categoryId => {
        const isCategory = _.find(cateList, { category_id: categoryId, })
        if (isCategory) {
          this._addInfoToCategory(isCategory)
        }
      })
    },
    _selectCategory(cate) {
      return this.selectCategory(cate)
    },
  },
  setting: {
    paren_category_txt: 'Danh mục hiển thị',
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
