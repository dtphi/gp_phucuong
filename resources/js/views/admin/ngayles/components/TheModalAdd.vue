<template>
  <modal name="modal-ngay-le-add" :height="555">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-plus"></i>Thêm Ngày Lễ</h3>

        <div slot="top-right" class="pull-right">
          <button @click="_hideModalEdit">❌</button>
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
                format="DD"
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
                format="MM"
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
                format="DD"
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
                format="MM-YYYY"
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
                rules="max:200"
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
          <input
            type="button"
            value="Hủy"
            class="btn btn-default"
            @click="_hideModalEdit"
          />
          <input
            type="button"
            value="Thêm"
            class="btn btn-primary"
            @click.prevent="_submitUpdate"
          />
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { config } from "@app/common/config";
import { MODULE_MODULE_NGAY_LE_ADD } from "store@admin/types/module-types";
import { ACTION_INSERT_INFO, ACTION_RESET_NOTIFICATION_INFO} from "store@admin/types/action-types";
import { mapState, mapActions } from "vuex";
export default {
  name: "TheModalAdd",
  data() {
    return {
      info: {
        code: null,
        ten_le: '',
        solar_day: '',
        solar_month: '',
        lunar_day: '',
        lunar_month: '',
        loai_le: 0,
        bac_le: 0,
        hanh: null,
        nam_ai: null,
        nam_aii: null,
        nam_bi: null,
        nam_bii: null,
        nam_ci: null,
        nam_cii: null,
      },
    };
  },
  computed: {
    ...mapState(MODULE_MODULE_NGAY_LE_ADD,{
      loading: (state) => state.loading,
      errors: (state) => state.errors,
      insertSuccess: (state) => state.insertSuccess,
    }),
    
    _errors() {
      return this.errors.length;
    },
  },
  watch: {
    insertSuccess(newValue, oldValue) {
      if (newValue) {
        this._notification(newValue);
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_NGAY_LE_ADD, {
      'insertInfo': ACTION_INSERT_INFO,
      'notification':ACTION_RESET_NOTIFICATION_INFO
    }),
    _hideModalEdit() {
      this.info = {};
      this.$modal.hide("modal-ngay-le-add");
    },
    _submitUpdate() {
        this.insertInfo(this.info);
        this._hideModalEdit();
    },
    _notification(notification){
      this.$notify(notification);
      this.notification("");
    }

     
  },
  setting: {
    cf: config,
    list_title: "Danh sách Ngày Lễ",
  },
};
</script>
