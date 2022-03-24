<template>
  <modal name="modal-thanh-add" :height="455">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-plus"></i>Thêm tên thánh</h3>
        <div slot="top-right" class="pull-right">
          <button @click="_hideModalEdit">❌</button>
        </div>
      </div>
      <div class="panel-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Tên thánh</label
            >
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
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Latin</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.latin"
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
              >Bổn mạng</label
            >
            <div class="col-sm-3">
              <p>Ngày:</p>
              <validation-provider
                name="info_bon_mang_ngay"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.bon_mang_ngay"
                  type="text"
                  id="input-info-bon-mang-ngay"
                />
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
            <div class="col-sm-3">
              <p>Tháng:</p>
              <validation-provider
                name="info_bon_mang_thang"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.bon_mang_thang"
                  type="text"
                  id="input-info-bon-mang-thang"
                />
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Ghi chú</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_ghi_chu"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea
                  class="form-control"
                  v-model="info.ghi_chu"
                ></textarea>
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Cuộc đời</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_ghi_chu"
                rules="max:200"
                v-slot="{ errors }"
              >
                <textarea
                  class="form-control"
                  v-model="info.cuoc_doi"
                ></textarea>
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
            value="Cập nhật"
            class="btn btn-primary"
            @click.prevent="_submitUpdate"
          />
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { MODULE_MODULE_THANH_ADD } from "store@admin/types/module-types";
import { ACTION_INSERT_INFO, ACTION_RESET_NOTIFICATION_INFO} from "store@admin/types/action-types";
import { mapState, mapActions } from "vuex";
export default {
  name: 'TheModalAdd',
  data() {
    return {
      info: {
        // active: 1,
        // ghi_chu: '',
        // id: null,
        // name: '',
        // ten_linh_muc: '',
        // type: 0,
      },
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_THANH_ADD,{
      loading: (state) => state.loading,
      insertSuccess: (state) => state.insertSuccess,
    }),
  },
  watch: {
    insertSuccess(newValue, oldValue) {
      if (newValue) {
        this._notification(newValue);
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_THANH_ADD, {
      'insertInfo': ACTION_INSERT_INFO,
      'notification':ACTION_RESET_NOTIFICATION_INFO
    }),
    _hideModalEdit() {
      this.info = {}
      this.$modal.hide('modal-thanh-add')
    },
    async _submitUpdate() {
      if(this.info.name !== '') {
        await this.insertInfo(this.info)
      }
    },
    _notification(notification) {
      if(notification.type == 'success') {
        this.info = {}
        this.$emit('add-info-success')
      }
      this.$notify(notification)
      this.notification('')
    },
  },
  setting: {
    list_title: 'Danh sách Linh mục',
  },
}
</script>
