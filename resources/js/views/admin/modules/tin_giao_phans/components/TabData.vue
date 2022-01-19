<template>
  <div class="tab-content">
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-code-name"
        >Mã Module Code</label
      >
      <div class="col-sm-10">
        <input
          disabled
          :value="texts[moduleData.code].text"
          type="text"
          placeholder="Mã Module Code"
          id="input-code-name"
          class="form-control"
        />
      </div>
    </div>
    <info-to-category-autocomplete-edit
      :info-category="category"
      :get-name-query="categoryName"
      :setting-category="categorySetting"
      :dropdown-category="categoryDropdownList"
      :reset-setting-category="_resetUpdateCategory"
      :select-category="_selectDropdownCategoryItem"
    ></info-to-category-autocomplete-edit>
  </div>
</template>

<script>
import { mapGetters, mapActions, } from 'vuex'
import InfoToCategoryAutocompleteEdit from '../../components/Category/InfoToCategoryAutocompleteEdit'
import mixinModule from '@app/mixins/admin/module'
import { MODULE_MODULE_TIN_GIAO_PHAN, } from 'store@admin/types/module-types'
import {
  ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA,
  ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
} from 'store@admin/types/action-types'

export default {
  name: 'TheTabData',
  mixins: [mixinModule],
  components: {
    InfoToCategoryAutocompleteEdit,
  },
  computed: {
    ...mapGetters(MODULE_MODULE_TIN_GIAO_PHAN, {
      category: 'infoCategory',
      categoryName: 'getNameQuery',
      categorySetting: 'settingCategory',
      categoryDropdownList: 'dropdownCategory',
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_TIN_GIAO_PHAN, {
      moduleUpdateResetSettingCategory:
        ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA,
      moduleSelectDropdownInfoToParentCategory:
        ACTION_SELECT_DROPDOWN_INFO_TO_PARENT_CATEGORY,
    }),
    _resetUpdateCategory(category) {
      this.moduleUpdateResetSettingCategory(category)
    },
    _selectDropdownCategoryItem(category) {
      this.moduleSelectDropdownInfoToParentCategory(category)
    },
  },
}
</script>
