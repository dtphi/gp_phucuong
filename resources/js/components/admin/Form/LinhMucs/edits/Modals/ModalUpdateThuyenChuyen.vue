<template>
  <modal name="modal-update-thuyen-chuyen" width="950" height="570">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-body">
        <form class="form-horizontal cms-modal-form">
          <div class="form-group">
            <div class="col-sm-10">
              <h3>Thông tin hoạt động sứ vụ</h3>
            </div>
          </div>
          <div class="form-group" v-if="info_thuyenchuyen_update.length === 0">
            <div class="col-sm-10">
              <h1>Thông tin hoạt động sứ vụ đã cập nhật !!!</h1>
            </div>
          </div>
          <div class="form-group" v-else>
            <div class="col-sm-10">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Chức vụ</th>
                    <th scope="col">Địa điểm</th>
                    <th scope="col">Công việc</th>
                    <th scope="col">Thời gian tới</th>
                    <th scope="col">Thời gian đi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, idx) in info_thuyenchuyen_update" :key="idx">
                    <th scope="row">{{ idx + 1 }}</th>
                    <td>{{ item.chucvuName }}</td>
                    <td>{{ diaDiemName(item) }}</td>
                    <td>{{ item.ghi_chu }}</td>
                    <td>{{ item.label_from_date  }}</td>
                    <td>{{ check_label_to_date(item) }}</td>
                  </tr>         
                </tbody>
              </table>
            </div>
          </div>
        </form>
        <div
          class="cms-modal-footer-btn"
          v-if="info_thuyenchuyen_update.length !== 0"
        >
          <div class="text-center cms-modal-group-btn">
            <input
              type="button"
              value="Đóng"
              class="btn btn-danger"
              @click="_hideModalEdit"
            />
            <input
              type="button"
              value="Cập nhật"
              class="btn btn-primary"
              @click.prevent="_addInfo"
            />
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT } from 'store@admin/types/module-types'

export default {
  name: 'ModalUpdateThuyenChuyen',
  data() {
    return {}
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
      info_thuyenchuyen_update: (state) => state.info_thuyenchuyen_update,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
      'GET_INFO_THUYENCHUYEN_UPDATE',
      'UPDATE_THUYENCHUYEN_IN_NEWTABLE',
    ]),
    _hideModalEdit() {
      this.$modal.hide('modal-update-thuyen-chuyen')
    },
    _addInfo() {
      const info = { id: this.$route.params.linhmucId, data: []}
      this.UPDATE_THUYENCHUYEN_IN_NEWTABLE(info)
      this._hideModalEdit()
    },
     diaDiemName: function(item) {
					if(item.giao_xu_id != 0) {
							return item.giaoxuName 
					}else if(item.co_so_gp_id != 0) {
							return item.cosogpName
					}else if(item.dong_id != 0) {
							return item.dongName
					}else {
							return item.banchuyentrachName
					}
		},
    check_label_to_date: function(item) {
        if(item.label_to_date === '') {
          return 'Cho đến nay'
        }else {
          return item.label_to_date
        }
      },
  },
  mounted() {
    const id = this.$route.params.linhmucId
    this.GET_INFO_THUYENCHUYEN_UPDATE(id)
  },
}
</script>