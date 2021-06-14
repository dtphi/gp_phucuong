<template>
    <div id="content">
        <!--<the-header-page></the-header-page>-->
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
                                <loading-over-lay
                                    :active.sync="loading"
                                    :is-full-page="fullPage"></loading-over-lay>
                            </template>
                            <template v-if="_infoList">
                                <div>
                                    <table
                                        class="table table-bordered table-hover">
                                        <thead>
                                        <tr role="row">
                                            <th style="width: 1px;" class="text-left">No
                                            </th>
                                            <th style="width: 1px;" class="text-center">
                                                <input type="checkbox"
                                                       onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                                            </th>
                                            <th style="width: 200px" class="text-left">Tên
                                            </th>
                                            <th style="width: 100px" class="text-left">
                                                Địa chỉ
                                            </th>
                                            <th>Ghi chú</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th style="width: 100px" class="text-center">
                                                Ngày hoạt động
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

                        <paginate :is-resource="isResource"></paginate>
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
    //import TheHeaderPage from './components/TheHeaderPage';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Paginate from 'com@admin/Pagination';
    import {
        MODULE_MODULE_GIAO_DIEM,
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'InformationList',
        components: {
            Breadcrumb,
            //TheHeaderPage,
            Item,
            Paginate
        },
        data() {
            return {
                fullPage: false,
                isResource: false,
            }
        },
        watch: {
            'updateSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        computed: {
            ...mapState({
                perPage: state => state.cfApp.perPage
            }),
            ...mapGetters(['isNotEmptyList']),
            ...mapState(MODULE_MODULE_GIAO_DIEM, [
                'infos',
                'loading',
                'updateSuccess',
            ]),
            _infoList() {
                return this.infos;
            },
            _notEmpty() {
                return this.isNotEmptyList;
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_GIAO_DIEM, [
                ACTION_GET_INFO_LIST,
                ACTION_RESET_NOTIFICATION_INFO,
            ]),
            _submitAction(event) {
                this[event.target.value]({
                    action: event.target.value
                });
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.[ACTION_RESET_NOTIFICATION_INFO]();
            },
        },
        mounted() {
            const params = {
                perPage: this.perPage
            };
            //this.[ACTION_GET_INFO_LIST](params);
        },
        setting: {
            list_title: 'Danh sách Linh mục'
        }
    };
</script>
