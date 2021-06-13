<template>
    <div class="form-group">
        <label 
        	class="col-sm-2 control-label" 
        	for="input-parent-ten-thanh-name">
        		<span data-toggle="tooltip" 
        			data-original-title="(Tự động hoàn toàn)">Tên thánh</span>
        	</label>
        <div class="col-sm-10" id="cms-scroll-dropdown">
    	   <input autocomplete="off"
                v-on:focus="_focusParentCategory"
	    		:value="query" type="text" 
	    		name="category" 
	    		placeholder="Chọn tên thánh" 
	    		id="input-parent-ten-thanh-name" 
	    		class="form-control" />
            <span class="btn btn-default cms-btn-input-right" @click="_closeDropdown">
                <font-awesome-layers size="2x" style="background:MistyRose">
                    <font-awesome-icon icon="search" class="fa-inverse" transform="shrink-4"/>
                </font-awesome-layers>
            </span>
            <ul class="dropdown-menu cms-ul-cate-dropdown" :style="dropdownStyle">
                <li v-for="(item,idx) in dropdowns" :key="idx" @click="_addInfoToCategory(item)" >
                    <a href="javascript:void(0);">{{item.name}}</a>
                </li>     
            </ul>
        </div>
    </div>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    import {
        MODULE_NEWS_CATEGORY
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_DROPDOWN_CATEGORY_LIST,
    } from 'store@admin/types/action-types';
    import lodash from 'lodash';

    export default {
        name: 'InfoTenThanhAutocomplete',
        props: {
            categoryId: {
                default: null
            }
        },
        data() {
            return {
                dropdownStyle: 'display: none;',
                query: '',           
            }
        },
        computed: {
            ...mapState(MODULE_NEWS_CATEGORY, {
                dropdowns: state => state.dropdownCategories
            }),
        },
        methods: {
        	...mapActions(MODULE_NEWS_CATEGORY, [
        		ACTION_GET_DROPDOWN_CATEGORY_LIST
        	]),
            _searchCategories() {
              const query = this.query;
              if (query && query.length) {
              	this.[ACTION_GET_DROPDOWN_CATEGORY_LIST](query);
              }
          },
          _focusParentCategory() {
            if (this.dropdowns.length == 0) {
                this.[ACTION_GET_DROPDOWN_CATEGORY_LIST]('');
                this.$data.dropdownStyle = 'display:block';
            } else {
                this.$data.dropdownStyle = 'display:block';
            }
          },
          _closeDropdown() {
              this.$data.dropdownStyle = 'display:none';
          },
          _addInfoToCategory(infoCategory) {
              this.query = infoCategory.name;
              this.$emit('on-select-giao-xu', infoCategory);
              this._closeDropdown();
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
