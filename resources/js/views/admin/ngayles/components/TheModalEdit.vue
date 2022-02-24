<template>
    <div class="panel panel-default" style="height:100%;overflow:auto">
        <template v-if="loading">
            <loading-over-lay
                :active.sync="loading"
                :is-full-page="fullPage"></loading-over-lay>
        </template>
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-edit"></i>Cập nhật Ngày lễ</h3>
            <div slot="top-right" class="pull-right">
                <button @click="_hideModalEdit">
                    ❌
                </button>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group">
            <label for="input-info-code" class="col-sm-2 control-label"
              >Code</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_code"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.code"
                  type="text"
                  id="input-info-code"
                  class="form-control"
                />
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Tên Lễ</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_TenLe"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.ten_le"
                  type="text"
                  id="input-info-name"
                  class="form-control"
                />

                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Solar Day</label
            >
            <div class="col-sm-10">
              <cms-date-picker
                value-type="format"
                format="D"
                v-model="info.solar_day"
                type="date"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Solar Month</label
            >
            <div class="col-sm-10">
              <cms-date-picker
                value-type="format"
                format="M"
                v-model="info.solar_month"
                type="month"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Lunar Day</label
            >
            <div class="col-sm-10">
              <cms-date-picker
                value-type="format"
                format="D"
                v-model="info.lunar_day"
                type="date"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Lunar Month</label
            >
            <div class="col-sm-10">
              <cms-date-picker
                value-type="format"
                format="M"
                v-model="info.lunar_month"
                type="month"
              ></cms-date-picker>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Loại Lễ</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_loaiLe"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.loai_le"
                  type="int"
                  id="input-info-code"
                  class="form-control"
                />
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Bậc Lễ</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.bac_le"
                  type="int"
                  id="input-info-code"
                  class="form-control"
                />
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Hành</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:20000"
                v-slot="{ errors }"
              >
                <textarea class="form-control" v-model="info.hanh"></textarea>

                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
            <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Năm AI</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea class="form-control" v-model="info.nam_ai"></textarea>

                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
            <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Năm AII</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea class="form-control" v-model="info.nam_aii"></textarea>

                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
            <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Năm BI</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea class="form-control" v-model="info.nam_bi"></textarea>

                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
            <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Năm BII</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea class="form-control" v-model="info.nam_bii"></textarea>

                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
            <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Năm CI</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea class="form-control" v-model="info.nam_ci"></textarea>

                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Năm CII</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea class="form-control" v-model="info.nam_cii"></textarea>

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
</template>

<script>
    import {
        mapActions, mapState
    } from 'vuex';
    import {
        MODULE_MODULE_NGAY_LE_EDIT,
    } from 'store@admin/types/module-types';
    import {
        ACTION_UPDATE_INFO,
        ACTION_RESET_NOTIFICATION_INFO 
    } from 'store@admin/types/action-types';
    import { config } from "@app/common/config";

    export default {
        name: 'TheModalEdit',
        props: {
            info: {
                type: Object,
                require: true,
                validator: function (value) {
                    return value.id && Number.isInteger(value.id)
                }
            }
        },
         mounted(){
            console.log(this.info)
        },
        data() {
            return {
                fullPage: false,
            }
        },
        computed: {
            ...mapState(MODULE_MODULE_NGAY_LE_EDIT, [
                'loading',
                'updateSuccess'
            ])
        },
        watch: {
            'updateSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            },
        },
        methods: {
            ...mapActions(MODULE_MODULE_NGAY_LE_EDIT, {
                'updateInfo': ACTION_UPDATE_INFO,
                'resetNotification': ACTION_RESET_NOTIFICATION_INFO
            }),
            _hideModalEdit() {
                this.$modal.hide('modal-ngay-le-edit');
            },
             _submitUpdate() {
                this.updateInfo(this.info);
                
                this._hideModalEdit;
            },
            _notificationUpdate(notification) {
                if (notification.type == 'success') {
                    this.$emit('update-info-success');
                }
                this.$notify(notification);
                this.resetNotification();
            },
        },
         setting: {
            cf: config,
            list_title: 'Danh sách Linh mục'
        }
    };
</script>
