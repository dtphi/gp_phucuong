<template>
  <div class="form-group">
    <label class="col-sm-1 control-label" for="input-parent-giao-hat-name">
      <span
        data-toggle="tooltip"
        data-original-title="(Tự động hoàn toàn)"
      ></span>
    </label>
    <div class="col-sm-11" id="cms-scroll-dropdown">
      <input
        autocomplete="off"
        v-on:focus="_focusParentCategory"
        :value="hat.hatName"
        type="text"
        name="category"
        placeholder="Chọn giáo hạt"
        id="input-parent-giao-hat-name"
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
  MODULE_MODULE_GIAO_PHAN,
  MODULE_MODULE_GIAO_PHAN_ADD,
} from 'store@admin/types/module-types'

export default {
  name: 'GiaoHatAutocomplete',
  props: {
    hat: {
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
    ...mapState(MODULE_MODULE_GIAO_PHAN, {
      dropdowns: (state) => state.dropdownGiaoHats,
    }),
    ...mapState(MODULE_MODULE_GIAO_PHAN_ADD, ['info']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN, [
      'ACTION_GET_DROPDOWN_GIAO_HAT_LIST'
    ]),
    ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, [
      'ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST'
    ]),
    _searchCategories() {
      const query = this.query
      if (query && query.length) {
        this.ACTION_GET_DROPDOWN_GIAO_HAT_LIST(query)
      }
    },
    _focusParentCategory() {
      if (this.dropdowns.length == 0) {
        this.ACTION_GET_DROPDOWN_GIAO_HAT_LIST('')
      } 
    },
    _closeDropdown() {
      this.isSearch = !this.isSearch
      this._focusParentCategory()
    },
    _addInfoToCategory(infoCategory) {
      const _self = this
      const isExistHat = _.find(_self.info.giao_phan_hats, {
        giao_hat_id: infoCategory.id,
      })

      if (isExistHat === undefined) {
        this.ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST({
          hat: _self.hat,
          hatInfo: infoCategory,
        })
      }

      this._closeDropdown()
    },
  },
}
</script>
