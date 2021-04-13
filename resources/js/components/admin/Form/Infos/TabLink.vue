<template>
    <div class="tab-content">

        <info-to-category-autocomplete></info-to-category-autocomplete>

        <info-to-related-autocomplete></info-to-related-autocomplete>

    </div>
</template>

<script>
    import {
        mapState, 
        mapGetters, 
        mapActions
    } from 'vuex';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_NEWS_CATEGORY_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST,
    } from 'store@admin/types/action-types';
     import InfoToCategoryAutocomplete from './Category/InfoToCategoryAutocomplete';
     import InfoToRelatedAutocomplete from './Related/InfoRelatedAutocomplete';

    export default {
        name: 'TabLinkForm',
        components: {
            InfoToCategoryAutocomplete,
            InfoToRelatedAutocomplete
        },
        props: {
            groupData: {
                type: Object
            }
        },

        computed: {
            ...mapState(MODULE_NEWS_CATEGORY,
            [
                'newsGroups'
            ]),
            ...mapGetters(MODULE_NEWS_CATEGORY, ['loading']),
            ...mapGetters(MODULE_NEWS_CATEGORY_ADD, ['isOpen']),
        },

        methods: {},

        setting: {}
    };
</script>
