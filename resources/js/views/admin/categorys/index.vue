<template>
	<div id="content">
        <the-header-page></the-header-page>
    <div class="container-fluid">
				    <div class="panel panel-default">
				      <div class="panel-heading">
				        <h3 class="panel-title">
                            <i class="fa fa-list"></i> Danh sách nhóm tin</h3>
				      </div>
	<div class="panel-body">
   <div id="form-category">
      <div class="table-responsive">
        <template v-if="loading">
            <loading-over-lay :active.sync="loading"
                              :is-full-page="fullPage"></loading-over-lay>
        </template>
        <template v-else>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center">
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                  </td>
                  <td class="text-left">                   
                    <a href="/" class="asc">Tên nhóm tin</a>
                  </td>
                  <td class="text-right">                    
                    <a href="/">Thứ tự</a>
                  </td>
                  <td class="text-right">Thực hiện</td>
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

    <div class="row">
		<div class="col-sm-6 text-left"><ul class="pagination"><li class="active"><span>1</span></li><li><a href="http://localhost.ptkngan/admin/index.php?route=catalog/category&amp;token=YIBse0xc677gPMl6gyEhNFMirylDeof0&amp;page=2">2</a></li><li><a href="http://localhost.ptkngan/admin/index.php?route=catalog/category&amp;token=YIBse0xc677gPMl6gyEhNFMirylDeof0&amp;page=2">&gt;</a></li><li><a href="http://localhost.ptkngan/admin/index.php?route=catalog/category&amp;token=YIBse0xc677gPMl6gyEhNFMirylDeof0&amp;page=2">&gt;|</a></li></ul></div>
				          <div class="col-sm-6 text-right">Showing 1 to 20 of 38 (2 Pages)</div>
				        </div>
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
            Breadcrumb
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
            ...mapState(MODULE_NEWS_CATEGORY_ADD, [
                'insertSuccess'
            ]),
            ...mapState(MODULE_NEWS_CATEGORY_EDIT, [
                'updateSuccess'
            ]),
            _lists() {
                let rootTree = {...this.newsGroups.children};

                return rootTree;
            }
        },
        watch: {
            'insertSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            },
            'updateSuccess'( newValue, oldValue ) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        methods: {
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.$store.dispatch(MODULE_NEWS_CATEGORY_ADD + '/' + ACTION_RESET_NOTIFICATION_INFO, '');
            }
        },
        setting: {
            title: 'News Groups List'
        }
    };
</script>
