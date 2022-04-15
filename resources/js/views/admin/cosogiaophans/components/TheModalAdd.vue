<template>
  <modal name="modal-co-so-add" :height="455">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-plus"></i>Thêm cơ sở</h3>
        <div slot="top-right" class="pull-right">
          <button @click="_hideModalEdit">❌</button>
        </div>
      </div>
      <div class="panel-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Tên cơ sở</label
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
              >Địa chỉ</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.dia_chi"
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
              >Email</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.email"
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
              >Điện thoại</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.dien_thoai"
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
              >Fax</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.fax"
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
              >Website</label
            >
            <div class="col-sm-10">
              <validation-provider
                name="info_name"
                rules="max:255"
                v-slot="{ errors }"
              >
                <input
                  v-model="info.website"
                  type="text"
                  id="input-info-name"
                  class="form-control"
                />
                <span class="cms-text-red">{{ errors[0] }}</span>
              </validation-provider>
            </div>
          </div>
          <div class="form-group">
            <label for="input-info-status" class="col-sm-2 control-label"
              >Cộng đoàn</label
            >
            <div class="col-sm-10">
              <select class="form-control" v-model="info.coso_giaophan">
                <option value="1" :selected="info.coso_giaophan == 1">Trong giáo phận</option>
                <option value="0" :selected="info.coso_giaophan == 0">Ngoài giáo phận</option>
              </select>
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
            @click.prevent="_submitAdd"
          />
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { MODULE_MODULE_CO_SO_ADD } from "store@admin/types/module-types";
import { ACTION_INSERT_INFO, ACTION_RESET_NOTIFICATION_INFO} from "store@admin/types/action-types";
import { mapState, mapActions } from "vuex";
export default {
  name: 'TheModalAdd',
  data() {
    return {
      info: {
        active: 1,
        ghi_chu: '',
        id: null,
        name: '',
        type: 0,
        coso_giaophan: 1,
      },
    }
  },
  computed: {
      ...mapState(MODULE_MODULE_CO_SO_ADD,{
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
    ...mapActions(MODULE_MODULE_CO_SO_ADD, {
      'insertInfo': ACTION_INSERT_INFO,
      'notification':ACTION_RESET_NOTIFICATION_INFO
    }),
    _hideModalEdit() {
      this.info = {}
      this.$modal.hide('modal-co-so-add')
    },
    async _submitAdd() {
      if(this.info.name !== '') {
        await this.insertInfo(this.info)
      }
    },
    _notification(notification) {
      if(notification.type == 'success') {
        this.info = {
          active: 1,
          coso_giaophan: 1
        }
        this.$emit('add-info-success')
      }
      this.$notify(notification)
      this.notification('')
    },
  },
  setting: {
    list_title: 'Danh sách cơ sở',
  },
}
</script>
