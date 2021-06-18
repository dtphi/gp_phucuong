<template>
    <div class="form-group">
        <label 
        	class="col-sm-1 control-label" 
        	for="input-parent-ban-chuyen-trach-name">
        		<span data-toggle="tooltip" 
        			data-original-title="(Tự động hoàn toàn)"></span>
        	</label>
        <div class="col-sm-11" id="cms-scroll-dropdown">
    	   <input autocomplete="off"
                v-on:focus="_focusParentCategory"
	    		:value="banChuyenTrach.banChuyenTrachName" type="text" 
	    		name="category" 
	    		placeholder="Chọn ban chuyên trách" 
	    		id="input-parent-ban-chuyen-trach-name" 
	    		class="form-control" />
            <span class="btn btn-default cms-btn-input-right" @click="_closeDropdown">
                <font-awesome-layers size="2x" style="background:#ddd">
                    <font-awesome-icon icon="circle" style="color:#ddd"/>
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
        MODULE_MODULE_LINH_MUC,
        MODULE_MODULE_GIAO_PHAN_EDIT
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_DROPDOWN_CATEGORY_LIST,
    } from 'store@admin/types/action-types';
    import lodash from 'lodash';

    export default {
        name: 'InfoBanChuyenTrachAutocomplete',
        props: {
            banChuyenTrach: {
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
            ...mapState(MODULE_MODULE_LINH_MUC, {
                dropdowns: state => state.dropdownBanChuyenTrachs
            }),
            ...mapState(MODULE_MODULE_GIAO_PHAN_EDIT, [
                'info'
            ])
        },
        methods: {
        	...mapActions(MODULE_MODULE_LINH_MUC, [
        		'ACTION_GET_DROPDOWN_BAN_CHUYEN_TRACH_LIST'
        	]),
            ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
        		'ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST',
        	]),
            _searchCategories() {
              const query = this.query;
              if (query && query.length) {
              	this.ACTION_GET_DROPDOWN_BAN_CHUYEN_TRACH_LIST(query);
              }
          },
          _focusParentCategory() {
            if (this.dropdowns.length == 0) {
                this.ACTION_GET_DROPDOWN_BAN_CHUYEN_TRACH_LIST('');
                this.$data.dropdownStyle = 'display:block';
            } else {
                this.$data.dropdownStyle = 'display:block';
            }
          },
          _closeDropdown() {
              this.$data.dropdownStyle = 'display:none';
          },
          _addInfoToCategory(infoCategory) {
              const _self = this;
              const isExist = _.find(_self.info.giao_phan_banchuyentrachs, { 'ban_chuyen_trach_id': infoCategory.id });
             
              if (isExist === undefined) {
                  this.ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST({
                      banChuyenTrach: _self.banChuyenTrach,
                      banChuyenTrachInfo: infoCategory
                  });
              }
              
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
