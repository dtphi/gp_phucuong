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
        name: 'TabNewsGroupForm',
        components: {
            InfoToCategoryAutocomplete,
            InfoToRelatedAutocomplete
        },
        beforeCreate() {
            this.$store.dispatch(MODULE_NEWS_CATEGORY + '/' + ACTION_GET_NEWS_GROUP_LIST);
        },

        props: {
            groupData: {
                type: Object
            }
        },

        data() {
            return {
                rootKey: 1
            };
        },

        mounted() {
            console.log('mounted tab')

            window.Echo.channel('search-user')
            .listen('.searchAllResults', (e) => {
                console.log(e);
            })
        },

        computed: {
            ...mapState(MODULE_NEWS_CATEGORY,
            [
                'newsGroups'
            ]),
            ...mapGetters(MODULE_NEWS_CATEGORY, ['loading']),
            ...mapGetters(MODULE_NEWS_CATEGORY_ADD, ['isOpen']),
            _lists() {
                let rootTree = {...this.newsGroups};

                return rootTree;
            },
            _selectedGroup() {
                return this.groupData.newsgroup_id ? this.groupData.newsgroupname : 'Not select'
            }
        },

        methods: {},

        setting: {}
    };
</script>
