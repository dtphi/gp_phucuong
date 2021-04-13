<template>
    <div class="form-group">
        <label 
        	class="col-sm-2 control-label" 
        	for="input-info-related">
        		<span data-toggle="tooltip" 
        			title="" 
        			data-original-title="(Tự động hoàn toàn)">{{$options.setting.paren_category_txt}}</span>
        	</label>
        <div class="col-sm-10">
    	   <input autocomplete="off"
                v-on:focus="_focusParentCategory"
	    		v-on:keyup.enter="_searchProducts()" 
	    		v-model="query" type="text" 
	    		name="informations" 
	    		:placeholder="$options.setting.paren_category_txt" 
	    		id="input-info-related" 
	    		class="form-control" />
            <ul class="dropdown-menu cms-ul-cate-dropdown" :style="dropdownStyle">
                <li>
                    <span class="btn btn-default cms-btn-dropdown" @click="_closeDropdown">
                        <font-awesome-layers size="2x" style="background:MistyRose">
                            <font-awesome-icon icon="circle" style="color:Tomato"/>
                            <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                        </font-awesome-layers>
                    </span>
                </li>
                <the-dropdown-related  :key="-1"
                    :category="itemNone"></the-dropdown-related>
              
                <the-dropdown-related v-for="(item,idx) in informations" :key="idx" 
                    :category="item"></the-dropdown-related>            
            </ul>

            <template v-if="relateds.length">
                <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <related-item 
                        v-for="(item,idx) in relateds" 
                        :key="idx" 
                        :info-to-related="item"></related-item>
                </div>
            </template>
            <template v-else>
                <div class="well well-sm" style="height: 150px; overflow: auto;"></div>
            </template>
        </div>
    </div>
</template>
e
<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import TheDropdownRelated from './DropdownToInfoRelatedAutocomplete';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_NEWS_CATEGORY_EDIT,
        MODULE_INFO_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST
    } from 'store@admin/types/action-types';
    import RelatedItem from './RelatedItem';

    export default {
        name: 'InfoRelatedAutocomplete',
        components: {
            TheDropdownRelated,
            RelatedItem
        },
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
                },
                informations: [],
                query: ''
            }
        },
        computed: {
            ...mapGetters(MODULE_NEWS_CATEGORY, [
                'newsGroups'
            ]),
            ...mapGetters(MODULE_NEWS_CATEGORY_EDIT, [
                'newsGroup',
                'getNameQuery'
            ]),
            ...mapState(MODULE_INFO_ADD, {
                relateds: state => state.listRelatedsDisplay
            }),
        },
        watch: {
            'getNameQuery': {
                handler: _.debounce(function () {
                    this._searchProducts()
                }, 100)
            }
        },
        methods: {
        	...mapActions(MODULE_NEWS_CATEGORY, [
        		ACTION_GET_NEWS_GROUP_LIST
        	]),
            _searchProducts() {
                /*this.$data.query = this.getNameQuery;
                  const query = this.getNameQuery;
                  if (query && query.length) {
                  	this.[ACTION_GET_NEWS_GROUP_LIST](query);
                  }*/
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
            paren_category_txt: 'Tin tức liên hệ'
        }
    };
</script>

<style type="text/css" lang="css" scoped>
    .cms-ul-cate-dropdown {
        top: 35px; 
        left: 15px;
    }
    .cms-ul-cate-dropdown > li > a:hover, .cms-dropdown-menu > li > a:focus {
        background-color: green !important
    }
    .cms-btn-dropdown {
        position: absolute;
        right: 0px;
        top: 0px;
        font-size: 0.5em;
    }
</style>
