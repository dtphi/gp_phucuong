<template>
    <div class="panel panel-default" style="height:100%;overflow:auto">
        <template v-if="loading">
            <loading-over-lay
                :active.sync="loading"
                :is-full-page="fullPage"></loading-over-lay>
        </template>
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
                        {{info.ten_linh_muc}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-ten-bang-cap" class="col-sm-2 control-label">Bằng cấp</label>
                    <div class="col-sm-10">
                        <validation-provider
                        name="ten_bang_cap"
                        rules="max:255"
                        v-slot="{ errors }"
                        >
                            <input
                                v-model="info.name"
                                type="text"
                                id="input-ten-bang-cap"
                                class="form-control"
                            />

                            <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-ghi-chu-bang-cap" class="col-sm-2 control-label">Ghi chú</label>
                    <div class="col-sm-10">
                        <validation-provider
                        name="ghi_chu_bang_cap"
                        rules="max:200"
                        v-slot="{ errors }"
                        >
                            <textarea class="form-control" v-model="info.ghi_chu"></textarea>

                            <span class="cms-text-red">{{ errors[0] }}</span>
                        </validation-provider>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-loai-bang-cap" class="col-sm-2 control-label">Loại</label>
                    <div class="col-sm-10">
                        <select id="input-loai-bang-cap" class="form-control" v-model="info.type">
                            <option value="0" :selected="info.type == 0">Loại 1</option>
                            <option value="1" :selected="info.type == 1">Loại 2</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-trang-thai-bang-cap" class="col-sm-2 control-label">Trạng thái</label>
                    <div class="col-sm-10">
                        <select id="input-trang-thai-bang-cap" class="form-control" v-model="info.active">
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
</template>

<script>
    import {
        mapActions, mapState
    } from 'vuex';
    import {
        MODULE_MODULE_BANG_CAP_EDIT,
    } from 'store@admin/types/module-types';
    import {
        ACTION_UPDATE_INFO,
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheModalEdit',
        props: {
            info: {
                type: Object,
                require: true,
                validator: function (value) {
                    return (value.id && Number.isInteger(value.id))
                }
            }
        },
        data() {
            return {
                fullPage: false,
            }
        },
        computed: {
            ...mapState(MODULE_MODULE_BANG_CAP_EDIT, [
                'loading'
            ])
        },
        methods: {
            ...mapActions(MODULE_MODULE_BANG_CAP_EDIT, {
               'updateInfo': ACTION_UPDATE_INFO
            }),
            _hideModalEdit() {
                this.$modal.hide('modal-linh-muc-bang-cap-edit');
            },
             _submitUpdate() {
                this.updateInfo(this.info);
                return 0;
            }
        }
    };
</script>
