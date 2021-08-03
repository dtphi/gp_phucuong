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
                                        <item v-for="(item,index) in _infoList"
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
        <modal name="modal-linh-muc-chuc-thanh-edit" :height="455">
            <div class="panel panel-default" style="height:100%;overflow:auto">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-edit"></i>Cập nhật bằng cấp</h3>
                    <div slot="top-right" class="pull-right">
                        <button @click="_hideModalEdit">
                            ❌
                        </button>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="input-info-name" class="col-sm-2 control-label">Linh mục</label>
                            <div class="col-sm-10">
                                {{_infoUpdate.ten_linh_muc}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-info-name" class="col-sm-2 control-label">Chức thánh</label>
                            <div class="col-sm-10">
                                <validation-provider
                                name="info_name"
                                rules="max:200"
                                v-slot="{ errors }"
                                >
                                    <select class="form-control" v-model="_infoUpdate.chuc_thanh_id">
                                        <option
                                            :selected="item.chuc_thanh_id == idx"
                                            :value="idx ? idx : ''"
                                            v-for="(item, idx) in $options.setting.cf.chucThanhs"
                                            :key="idx"
                                            >
                                            {{ item }}
                                        </option>
                                    </select>
                                <span class="cms-text-red">{{ errors[0] }}</span>
                                </validation-provider>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-info-name" class="col-sm-2 control-label">Người thụ phong</label>
                            <div class="col-sm-10">
                                <validation-provider
                                name="info_name"
                                rules="max:255"
                                v-slot="{ errors }"
                                >
                                <input
                                    v-model="_infoUpdate.nguoi_thu_phong"
                                    type="text"
                                    id="input-info-name"
                                    class="form-control"
                                />

                                <span class="cms-text-red">{{ errors[0] }}</span>
                                </validation-provider>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-info-name" class="col-sm-2 control-label">Nơi thụ phong</label>
                            <div class="col-sm-10">
                                <validation-provider
                                name="info_name"
                                rules="max:255"
                                v-slot="{ errors }"
                                >
                                <input
                                    v-model="_infoUpdate.noi_thu_phong"
                                    type="text"
                                    id="input-info-name"
                                    class="form-control"
                                />

                                <span class="cms-text-red">{{ errors[0] }}</span>
                                </validation-provider>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-info-name" class="col-sm-2 control-label">Ngày tháng</label>
                            <div class="col-sm-10">
                                <cms-date-picker
                                    value-type="format"
                                    format="YYYY-MM-DD"
                                    v-model="_infoUpdate.ngay_thang"
                                    type="date"
                                ></cms-date-picker>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-info-name" class="col-sm-2 control-label">Ghi chú</label>
                            <div class="col-sm-10">
                                <validation-provider
                                name="info_ghi_chu"
                                rules="max:200"
                                v-slot="{ errors }"
                                >
                                <textarea class="form-control" v-model="_infoUpdate.ghi_chu"></textarea>

                                <span class="cms-text-red">{{ errors[0] }}</span>
                                </validation-provider>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-info-name" class="col-sm-2 control-label">Trạng thái</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="_infoUpdate.active">
                                    <option value="1" :selected="_infoUpdate.active == 1">Xảy ra</option>
                                    <option value="0" :selected="_infoUpdate.active == 0">Ẩn</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="container-fluid">
                    <div class="pull-right">
                        <input type="button" value="Hủy" class="btn btn-default"
                            @click="_hideModalEdit"
                        />
                        <input type="button" value="Cập nhật" class="btn btn-primary"
                            @click.prevent="_submitUpdate"/>
                    </div>
                </div>
            </div>
        </modal>
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
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';
    //import { config } from 'vue/types/umd';
    import { config } from "@app/common/config";

    export default {
        name: 'InformationList',
        components: {
            Breadcrumb,
            TheHeaderPage,
            Item,
            Paginate
        },
        data() {
            return {
                fullPage: false,
                isResource: false,
                infoUpdate: {}
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
            ...mapState(MODULE_MODULE_CHUC_THANH, [
                'infos',
                'loading',
                'updateSuccess',
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
            _showModalEdit(info) {console.log(info)
                this.infoUpdate = info;
                this.$modal.show('modal-linh-muc-chuc-thanh-edit');
            },
            _hideModalEdit() {
                this.infoUpdate = {};
                this.$modal.hide('modal-linh-muc-chuc-thanh-edit');
            },
             _submitUpdate() {
                alert('update db')
            },
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
            this.[ACTION_GET_INFO_LIST](params);
        },
        setting: {
            cf: config,
            list_title: 'Danh sách Linh mục'
        }
    };
</script>
