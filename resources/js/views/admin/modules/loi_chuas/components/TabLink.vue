<template>
    <div class="tab-content">
        <info-to-category-autocomplete-edit></info-to-category-autocomplete-edit>
    </div>
</template>

<script>
     import InfoToCategoryAutocompleteEdit from './Category/InfoToCategoryAutocompleteEdit';

    export default {
        name: 'TabLinkForm',
        components: {
            InfoToCategoryAutocompleteEdit
        },
        props: {
            isForm: {
                type: String,
                default: ''
            },
            groupData: {
                type: Object
            }
        },
        computed: {
        },
    };
</script>
