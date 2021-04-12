<template>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="input-parent-category-name">
            <span data-toggle="tooltip" data-original-title="(Tự động hoàn toàn)">{{$options.setting.paren_category_txt}}</span>
        </label>
        <div class="col-sm-10">
    	   <input autocomplete="off"
            v-on:focus="_focusParentCategory"
    		v-on:keyup.enter="_searchProducts()" 
    		v-model="newsGroupAdd.nameQuery" type="text" 
    		name="category" 
    		:placeholder="$options.setting.paren_category_txt" 
    		id="input-parent-category-name" 
    		class="form-control" />
            <ul class="dropdown-menu cms-dropdown-menu cms-ul-cate-dropdown" :style="dropdownStyle">
                <li>
                    <span class="btn btn-default cms-btn-dropdown" @click="_closeDropdown">
                        <font-awesome-layers size="2x" style="background:MistyRose">
                            <font-awesome-icon icon="circle" style="color:Tomato"/>
                            <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                        </font-awesome-layers>
                    </span>
                </li>
                <the-dropdown-category  :key="-1"
                    :category="itemNone"></the-dropdown-category>
              
                <the-dropdown-category v-for="(item,idx) in newsGroups" :key="idx" 
                    :category="item"></the-dropdown-category>            
            </ul>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import TheDropdownCategory from './TheDropdownCategory';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_NEWS_CATEGORY_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST
    } from 'store@admin/types/action-types';
    import lodash from 'lodash';

    export default {
        name: 'CategoryAutocomplete',
        components: {TheDropdownCategory},
        props: {
            categoryId: {
                default: 0
            }
        },
        data() {
            return {
                dropdownStyle: 'display: none;',
                itemNone: {
                    category_id: 0,
                    category_name: ' --- Chọn --- ',
                    sort_order: 0
                }            
            }
        },
        computed: {
            ...mapGetters(MODULE_NEWS_CATEGORY, [
                'newsGroups'
            ]),
            ...mapGetters(MODULE_NEWS_CATEGORY_ADD, [
                'newsGroupAdd'
            ])
        },
        watch: {
            'newsGroupAdd.nameQuery': {
                handler: _.debounce(function () {
                    this._searchProducts()
                }, 100)
            }
        },
        methods: {
        	...mapActions(MODULE_NEWS_CATEGORY, [ACTION_GET_NEWS_GROUP_LIST]),
            _searchProducts() {
                const query = this.newsGroupAdd.nameQuery;
                if (query && query.length) {
                	this.[ACTION_GET_NEWS_GROUP_LIST](query);
                }
            },
            _focusParentCategory() {
                this.[ACTION_GET_NEWS_GROUP_LIST]();
                this.$data.dropdownStyle = 'display:block';
            },
            _closeDropdown() {
                this.$data.dropdownStyle = 'display:none';
            }
        },
        setting: {
            paren_category_txt: 'Danh mục tin tức cha'
        }
    };
</script>

<style type="text/css" lang="css" scoped>
    .cms-ul-cate-dropdown {
        top: 35px; 
        left: 15px;
    }
    .cms-btn-dropdown {
        position: absolute;
        right: 0px;
        top: 0px;
        font-size: 0.5em;
    }
    .cms-dropdown-menu > li > a:hover, .cms-dropdown-menu > li > a:focus {
        background-color: green !important
    }
</style>
