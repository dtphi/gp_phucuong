<template>
    <div id="content">
        <the-header-page
            @show-modal-add="_showModalAdd"
        ></the-header-page>
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
                                            <th style="width: 200px" class="text-left">Tên người thụ phong
                                            </th>
                                            <th style="width: 100px" class="text-left">
                                                Linh mục
                                            </th>
                                            <th style="width: 100px" class="text-left">
                                                Chức thánh
                                            </th>
                                            <th style="width: 100px" class="text-left">
                                                Nơi thụ phong
                                            </th>
                                            <th style="width: 100px" class="text-left">
                                                Ngày tháng
                                            </th>
                                            <th>Ghi chú</th>
                                            <th class="text-center">Trạng thái</th>
                                            
                                            <th style="width: 100px" class="text-right">Action
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <item 
                                            v-for="(item,index) in _infoList"
                                            :info="item"
                                            :no="index"
                                            :key="item.id"
                                            @show-modal-edit="_showModalEdit"
                                        ></item>
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
        <modal name="modal-linh-muc-chuc-thanh-edit" :height="455" :click-to-close="false">
            <the-modal-edit v-if="_infoUpdate.id"
                :info="_infoUpdate"
                :info-id="_infoUpdate.id"
                @update-info-success="_updateInfoList"
            ></the-modal-edit>
        </modal>
        <the-modal-add></the-modal-add>
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
        MODULE_MODULE_CHUC_THANH,
        MODULE_MODULE_CHUC_THANH_EDIT
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';
    //import { config } from 'vue/types/umd';
    import { config } from "@app/common/config";
    import TheModalAdd from './components/TheModalAdd';
    import TheModalEdit from './components/TheModalEdit';

    export default {
        name: 'DanhSachLinhMucChucThanh',
        components: {
            Breadcrumb,
            TheHeaderPage,
            Item,
            Paginate,
            TheModalAdd,
            TheModalEdit
        },
        data() {
            return {
                fullPage: false,
                isResource: false,
                infoUpdate: {},
                curInfo: {}
            }
        },
        watch: {
            'isDelete'(newValue, oldValue) {
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
            ...mapState(MODULE_MODULE_CHUC_THANH, [
                'infos',
                'loading',
                'isDelete',
            ]),
            ...mapState(MODULE_MODULE_CHUC_THANH_EDIT, [
                'info',
            ]),
            _infoList() {
                return this.infos;
            },
            _notEmpty() {
                return this.isNotEmptyList;
            },
            _infoUpdate() {
                return this.infoUpdate
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_CHUC_THANH, [
                ACTION_GET_INFO_LIST,
                ACTION_RESET_NOTIFICATION_INFO,
            ]),
            _showModalAdd() {
                this.$modal.show('modal-linh-muc-chuc-thanh-add')
            },
            _showModalEdit(info) {
                this.curInfo = info;
                this.infoUpdate = {...info};
                this.$modal.show('modal-linh-muc-chuc-thanh-edit');
            },
            _updateInfoList() {
                this.curInfo.chuc_thanh_id = this.info.chuc_thanh_id;
                this.curInfo.ngay_thang = this.info.ngay_thang;
                this.curInfo.noi_thu_phong = this.info.noi_thu_phong;
                this.curInfo.nguoi_thu_phong = this.info.nguoi_thu_phong;
                this.curInfo.ghi_chu = this.info.ghi_chu;
                this.curInfo.active = this.info.active;
                
                this.$modal.hide('modal-linh-muc-chuc-thanh-edit');
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
            this.[ACTION_GET_INFO_LIST](params);
        },
        setting: {
            cf: config,
            list_title: 'Danh sách Linh mục'
        }
    };
</script>
