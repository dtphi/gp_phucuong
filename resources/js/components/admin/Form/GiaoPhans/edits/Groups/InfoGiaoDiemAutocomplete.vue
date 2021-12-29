<template>
  <div class="form-group">
    <label class="col-sm-1 control-label" for="input-parent-giao-diem-name">
      <span
        data-toggle="tooltip"
        data-original-title="(Tự động hoàn toàn)"
      ></span>
    </label>
    <div class="col-sm-11" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="query"
        type="text"
        name="category"
        placeholder="Chọn giáo điểm"
        id="input-parent-giao-diem-name"
        class="form-control"
      />
      <span class="btn btn-default cms-btn-input-right" @click="_closeDropdown">
        <font-awesome-layers size="2x" style="background: #ddd">
          <font-awesome-icon icon="circle" style="color: #ddd" />
          <font-awesome-icon
            icon="search"
            class="fa-inverse"
            transform="shrink-4"
          />
        </font-awesome-layers>
      </span>
      <ul class="dropdown-menu cms-ul-cate-dropdown" :style="dropdownStyle">
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
import { MODULE_MODULE_GIAO_PHAN, } from 'store@admin/types/module-types'

export default {
  name: 'DongAutocomplete',
  props: {
    categoryId: {
      default: null,
    },
  },
  data() {
    return {
      dropdownStyle: 'display: none;',
      query: '',
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GIAO_PHAN, {
      dropdowns: (state) => state.dropdownGiaoDiems,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN, [
      'ACTION_GET_DROPDOWN_GIAO_DIEM_LIST'
    ]),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.ACTION_GET_DROPDOWN_GIAO_DIEM_LIST(query)
      }
    },
    _focusParentCategory() {
      if (this.dropdowns.length == 0) {
        this.ACTION_GET_DROPDOWN_GIAO_DIEM_LIST('')
        this.$data.dropdownStyle = 'display:block'
      } else {
        this.$data.dropdownStyle = 'display:block'
      }
    },
    _closeDropdown() {
      this.$data.dropdownStyle = 'display:none'
    },
    _addInfoToCategory(infoCategory) {
      this.query = infoCategory.name
      this.$emit('on-select-giao-xu', infoCategory)
      this._closeDropdown()
    },
  },
  setting: {
    paren_category_txt: 'Danh mục tin tức cha',
  },
}
</script>