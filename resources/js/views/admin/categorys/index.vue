<template>
	<div id="content">
        <the-header-page></the-header-page>
            <div class="container-fluid">
        				    <div class="panel panel-default">
        				      <div class="panel-heading">
        				        <h3 class="panel-title">
                                    <i class="fa fa-list"></i>{{$options.setting.list_title}}</h3>
        				      </div>
        	<div class="panel-body">
           <div id="form-category">
              <div class="table-responsive">
                <template v-if="loading">
                    <loading-over-lay :active.sync="loading"
                                      :is-full-page="fullPage"></loading-over-lay>
                </template>
                <template v-if="_lists">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td style="width: 1px;" class="text-center">
                            <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                          </td>
                          <td class="text-left">                   
                            <a href="javascript:void(0);" class="asc">Tên nhóm tin</a>
                          </td>
                          <td style="width: 100px" class="text-center">                    
                            <a href="javascript:void(0);" class="asc">Sắp xếp</a>
                          </td>
                          <td style="width: 100px" class="text-right">Thực hiện</td>
                        </tr>
                      </thead>
                      <tbody>
                        <the-category-item 
                            v-for="(item, idx) in _lists" 
                            :category-item="item" 
                            :key="idx"></the-category-item>
                        </tbody>
                    </table>
                </template>
              </div>
            </div>

            <paginate></paginate>
				    </div>
				  </div>
			</div>
        </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import TheCategoryItem from './components/TheCategoryItem';
    import TheHeaderPage from './components/TheHeaderPage';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Paginate from 'com@admin/Pagination';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_NEWS_CATEGORY_ADD,
        MODULE_NEWS_CATEGORY_EDIT
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'CategoryListPage',
        components: {
        	TheCategoryItem,
            TheHeaderPage,
            Breadcrumb,
            Paginate
        },
        beforeCreate() {
            this.$store.dispatch(MODULE_NEWS_CATEGORY + '/' + ACTION_GET_NEWS_GROUP_LIST);
        },
        data() {
            return {
                fullPage: false
            };
        },
        computed: {
            ...mapState(MODULE_NEWS_CATEGORY,
            [
                'newsGroups',
                'loading'
            ]),
            _lists() {
                let rootTree = {...this.newsGroups.children};

                return rootTree;
            }
        },
        methods: {
        },
        setting: {
            list_title: 'Danh sách danh mục tin'
        }
    };
</script>
