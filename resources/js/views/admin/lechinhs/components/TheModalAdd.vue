<template>
    <modal name="modal-le-chinh-add" :height="255">
        <div class="panel panel-default" style="height:100%;overflow:auto">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-plus"></i>Thêm lễ chính</h3>

                <div slot="top-right" class="pull-right">
                    <button @click="_hideModalEdit">
                        ❌
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Mã</label>
                        <div class="col-sm-10">
                            <validation-provider
                            name="info_name"
                            rules="max:255"
                            v-slot="{ errors }"
                            >
                            <input
                                v-model="info.code"
                                type="text"
                                id="input-info-name"
                                class="form-control"
                            />

                            <span class="cms-text-red">{{ errors[0] }}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-info-name" class="col-sm-2 control-label">Tên lễ</label>
                        <div class="col-sm-10">
                            <validation-provider
                            name="info_name"
                            rules="max:255"
                            v-slot="{ errors }"
                            >
                            <input
                                v-model="info.name"
                                type="text"
                                id="input-info-name"
                                class="form-control"
                            />

                            <span class="cms-text-red">{{ errors[0] }}</span>
                            </validation-provider>
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
        fn_redirect_url
    } from '@app/api/utils/fn-helper';
    import { config } from "@app/common/config";

    export default {
        name: 'TheModalAdd',
        data() {
            return {
                info: {
                    active: 1,
                    ghi_chu: "",
                    id: null,
                    name: "",
                    ten_linh_muc: "",
                    type: 0
                }
            }
        },
        methods: {
            _hideModalEdit() {
                this.info = {};
                this.$modal.hide('modal-le-chinh-add');
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
