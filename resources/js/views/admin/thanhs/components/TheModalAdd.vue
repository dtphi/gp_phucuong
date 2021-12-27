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
            <div class="col-sm-10">
              <cms-date-picker
                value-type="format"
                format="YYYY-MM-DD"
                v-model="info.bon_mang"
                type="date"
              ></cms-date-picker>
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
          <div class="form-group">
            <label for="input-info-name" class="col-sm-2 control-label"
              >Trạng thái</label
            >
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
export default {
  name: 'TheModalAdd',
  data() {
    return {
      info: {
        active: 1,
        ghi_chu: '',
        id: null,
        name: '',
        ten_linh_muc: '',
        type: 0,
      },
    }
  },
  methods: {
    _hideModalEdit() {
      this.info = {}
      this.$modal.hide('modal-thanh-add')
    },
    _submitUpdate() {
      return 0
    },
  },
  setting: {
    list_title: 'Danh sách Linh mục',
  },
}
</script>
