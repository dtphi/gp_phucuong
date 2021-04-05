<template>
    <div id="content">
        <the-header-page></the-header-page>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                    <i class="fa fa-list"></i> {{$options.setting.list_title}}</h3>
                </div>
                <div class="panel-body">
                    <div id="form-category">
                        <div class="table-responsive">
                            <template v-if="loading">
                                <loading-over-lay :active.sync="loading"
                                                  :is-full-page="fullPage"></loading-over-lay>
                            </template>
                            <template v-else>
                                <div>
                                    <table
                                        class="table table-bordered table-hover">
                                        <thead>
                                            <tr role="row">
                                                <th style="width: 1px;" class="text-center">No
                                                </th>
                                                <th style="width: 1px;" class="text-center">
                                                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                                                </th>
                                            
                                                <th style="width: 200px" class="text-left">Tên
                                                </th>
                                                <th style="width: 5px" class="text-right">
                                                    Hình ảnh
                                                </th>
                                                <th class="text-left">
                                                    Mô tả
                                                </th>
                                                <th style="width: 100px" class="text-center">
                                                    Ngày tạo
                                                </th>
                                                <th style="width: 100px" class="text-right">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <item v-for="(item,index) in _infoList"
                                                  :info="item"
                                                  :no="index"
                                                  :key="item.id"></item>
                                        </tbody>
                                    </table>
                            
                                </div>
                            </template>
                        </div>

                        <paginate></paginate>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import Item from './components/TheItem';

    import TheHeaderPage from './components/TheHeaderPage';

    import Breadcrumb from 'com@admin/Breadcrumb';
    
    import Paginate from 'com@admin/Pagination';
    
    import {
        MODULE_INFO,
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST,
    } from 'store@admin/types/action-types';

    export default {
        name: 'InformationList',
        components: {
            Breadcrumb,
            TheHeaderPage,
            Item,
            Paginate
        },

        beforeCreate() {
            this.$store.dispatch(MODULE_INFO + '/' + ACTION_GET_INFO_LIST);
        },

        data() {
            return {
                fullPage: false
            }
        },

        computed: {
            ...mapGetters(['isNotEmptyList']),
            ...mapState(MODULE_INFO, [
                'infos',
                'loading'
            ]),

            _infoList() {
                return this.infos;
            },

            _notEmpty() {
                return this.isNotEmptyList;
            }
        },
        setting: {
            list_title: 'Danh sách tin tức'
        }
    };
</script>
