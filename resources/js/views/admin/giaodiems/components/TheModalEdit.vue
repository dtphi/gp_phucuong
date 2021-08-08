<template>
    <modal name="modal-giao-diem-edit" :height="455">
        <div class="panel panel-default" style="height:100%;overflow:auto">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-edit"></i>Cập nhật giáo điểm</h3>
                <div slot="top-right" class="pull-right">
                    <button @click="_hideModalEdit">
                        ❌
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Giáo phận</label>
                        <div class="col-sm-10">
                            {{info.ten_linh_muc}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Giáo hạt</label>
                        <div class="col-sm-10">
                            {{info.ten_linh_muc}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Giáo xứ</label>
                        <div class="col-sm-10">
                            {{info.ten_linh_muc}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Tên giáo điểm</label>
                        <div class="col-sm-10">
                            <validation-provider
                            name="info_name"
                            rules="max:255"
                            v-slot="{ errors }"
                            >
                            <input
                                v-model="info.nguoi_thu_phong"
                                type="text"
                                id="input-info-name"
                                class="form-control"
                            />

                            <span class="cms-text-red">{{ errors[0] }}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-sm-10">
                            <validation-provider
                            name="info_name"
                            rules="max:255"
                            v-slot="{ errors }"
                            >
                            <input
                                v-model="info.noi_thu_phong"
                                type="text"
                                id="input-info-name"
                                class="form-control"
                            />

                            <span class="cms-text-red">{{ errors[0] }}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Sắp xếp</label>
                        <div class="col-sm-10">
                            <validation-provider
                            name="info_name"
                            rules="max:255"
                            v-slot="{ errors }"
                            >
                            <input
                                v-model="info.noi_thu_phong"
                                type="number"
                                id="input-info-name"
                                class="form-control"
                            />

                            <span class="cms-text-red">{{ errors[0] }}</span>
                            </validation-provider>
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
                            <textarea class="form-control" v-model="info.ghi_chu"></textarea>

                            <span class="cms-text-red">{{ errors[0] }}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Trạng thái</label>
                        <div class="col-sm-10">
                            <select class="form-control" v-model="info.active">
                                <option value="1" :selected="info.active == 1">Xảy ra</option>
                                <option value="0" :selected="info.active == 0">Ẩn</option>
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
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';
    import { config } from "@app/common/config";

    export default {
        name: 'TheModalEdit',
        props: {
            info: {
                type: Object,
                default: {}
            },
            infoId: {
                type: Number,
                default: 0,
                validator: function (value) {
                    return (value && Number.isInteger(value))
                }
            }
        },
        data() {
            return {};
        },
        methods: {
            _hideModalEdit() {
                this.infoUpdate = {};
                this.$modal.hide('modal-giao-diem-edit');
            },
             _submitUpdate() {
               return 0;
            },
        },
         setting: {
            cf: config,
            list_title: 'Danh sách Linh mục'
        }
    };
</script>
