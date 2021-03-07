<template>
    <div class="input-group input-group-sm">
        <input v-model="query" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="button" @click="searchProducts" @keyup.enter="searchProducts">
                <font-awesome-icon icon="search"/>
            </button>
        </div>
    </div>
</template>

<script>
	import {
      MODULE_USER
  } from 'store@admin/types/module-types';
  import {
    ACTION_GET_USER_LIST
    } from 'store@admin/types/action-types';
  import lodash from 'lodash';

    export default {
        name: 'AllSearch',
        components: {},
        data() {
            return {
                query: '',
            }
        },
        watch: {
            /*query: {
                handler: _.debounce(function () {
                    this.searchProducts()
                }, 100)
            }*/
        },
        methods: {
            searchProducts() {
                if (this.query && this.query.length) {
                    this.$store.dispatch(MODULE_USER + '/' +'SEARCH_PRODUCTS', this.query)
                } else {
                    this.$store.dispatch(MODULE_USER + '/' + ACTION_GET_USER_LIST)
                }
            }
        }
    };
</script>
