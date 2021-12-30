<template>
  <div class="tab-content">
    <template v-if="_isAdd">
      <info-to-category-autocomplete></info-to-category-autocomplete>
      <info-to-related-autocomplete></info-to-related-autocomplete>
    </template>
    <template v-if="_isEdit">
      <info-to-category-autocomplete-edit></info-to-category-autocomplete-edit>
    </template>
  </div>
</template>

<script>
import InfoToCategoryAutocomplete from './Category/InfoToCategoryAutocomplete'
import InfoToRelatedAutocomplete from './Related/InfoRelatedAutocomplete'
import InfoToCategoryAutocompleteEdit from './Category/InfoToCategoryAutocompleteEdit'

export default {
  name: 'TabLinkForm',
  components: {
    InfoToCategoryAutocomplete,
    InfoToRelatedAutocomplete,
    InfoToCategoryAutocompleteEdit,
  },
  props: {
    isForm: {
      type: String,
      default: '',
    },
    groupData: {
      type: Object,
    },
  },
  computed: {
    _isAdd() {
      if (this.isForm == 'add') {
        return true
      }

      return false
    },
    _isEdit() {
      if (this.isForm == 'edit') {
        return true
      }

      return false
    },
  },
}
</script>
