<template>
	<input 
		v-on:keyup.enter="searchProducts()" 
		v-model="query" type="text" 
		name="category" 
		placeholder="Danh mục tin tức" 
		id="input-category" 
		class="form-control" />
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_NEWS_CATEGORY
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST
    } from 'store@admin/types/action-types';
    import lodash from 'lodash';

    export default {
        name: 'CategoryAutocomplete',
        components: {},
        data() {
            return {
                query: '',
            }
        },
        watch: {
            query: {
                handler: _.debounce(function () {
                    this.searchProducts()
                }, 100)
            }
        },
        methods: {
        	...mapActions(MODULE_NEWS_CATEGORY, [ACTION_GET_NEWS_GROUP_LIST]),
            searchProducts() {
                if (this.query && this.query.length) {
                	this.[ACTION_GET_NEWS_GROUP_LIST](this.query);
                }
            }
        }
    };
</script>
