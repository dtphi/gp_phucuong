<template>
  <modal name="modal-update-linh-muc" width="800" height="570">
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-body">
        <form class="form-horizontal cms-modal-form">
          <div class="form-group">
            <div class="col-sm-10">
              <h3>Thông tin linh mục</h3>
            </div>
          </div>
          <div class="form-group" v-if="Object.keys(info_linhmuc_update).length === 0">
            <div class="col-sm-10">
              <h1>Thông tin linh mục đã cập nhật !!!</h1>
            </div>
          </div>
          <div class="form-group" v-else>
            <div class="col-sm-10">
              <h5>Tên thánh           : {{info_linhmuc_update.ten_thanh_name }}</h5>
              <h5>Tên                 : {{info_linhmuc_update.ten }}</h5>
              <h5>Năm sinh            : {{info_linhmuc_update.lable_ngay_thang_nam_sinh }}</h5>
              <h5>Nơi sinh            : {{info_linhmuc_update.noi_sinh }}</h5>
              <h5>Họ tên cha          : {{info_linhmuc_update.ho_ten_cha }}</h5>
              <h5>Họ tên mẹ           : {{info_linhmuc_update.ho_ten_me }}</h5>
              <h5>Sinh tại xứ         : {{info_linhmuc_update.sinh_giao_xu }}</h5>
              <h5>Hình ảnh            : {{info_linhmuc_update.image }}</h5>
              <h5>Ngày rửa tội        : {{info_linhmuc_update.lable_ngay_rua_toi }}</h5>
              <h5>Nơi rửa tội         : {{info_linhmuc_update.noi_rua_toi }}</h5>
              <h5>Ngày thêm sức       : {{info_linhmuc_update.lable_ngay_them_suc }}</h5>
              <h5>Nơi thêm sức        : {{info_linhmuc_update.noi_them_suc }}</h5>
              <h5>Tiểu chủng viện     : {{info_linhmuc_update.tieu_chung_vien }}</h5>
              <h5>Ngày tiểu chủng viện: {{info_linhmuc_update.lable_ngay_tieu_chung_vien }}</h5>
              <h5>Đại chủng viện      : {{info_linhmuc_update.dai_chung_vien }}</h5>
              <h5>Ngày đại chủng viện : {{info_linhmuc_update.lable_ngay_dai_chung_vien }}</h5>
              <h5>Email               : {{info_linhmuc_update.email }}</h5>
              <h5>Ngày khấn           : {{info_linhmuc_update.lable_ngay_khan }}</h5>
              <h5>Tên dòng            : {{info_linhmuc_update.ten_dong_name }}</h5>
              <h5>Ngày triều dòng     : {{info_linhmuc_update.lable_ngay_trieu_dong }}</h5>
              <h5>CMND                : {{info_linhmuc_update.so_cmnd }}</h5>
              <h5>Ngày cấp CMND       : {{info_linhmuc_update.lable_ngay_cap_cmnd }}</h5>  
              <h5>Nơi cấp             : {{info_linhmuc_update.noi_cap_cmnd }}</h5>    
              <h5>Số điện thoại       : {{info_linhmuc_update.phone }}</h5>
              <h5>Email               : {{info_linhmuc_update.email }}</h5>
              <h5>Châm ngôn           : {{info_linhmuc_update.cham_ngon }}</h5>
              <h5>Ghi chú             : {{info_linhmuc_update.ghi_chu }}</h5>
            </div>
          </div>       
        </form>
        <div class="cms-modal-footer-btn" v-if="Object.keys(info_linhmuc_update).length !== 0">
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
  name: 'ModalUpdateLinhMuc',
  data() {
    return {
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
      info_linhmuc_update: (state) => state.info_linhmuc_update
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
      'GET_INFO_LINHMUC_UPDATE', 
      'UPDATE_LINHMUC_IN_NEWTABLE'
    ]), 
    _hideModalEdit() {
      this.$modal.hide('modal-update-linh-muc')
    },
    _addInfo() {
        this.UPDATE_LINHMUC_IN_NEWTABLE(this.info_linhmuc_update)
        this._hideModalEdit()
    },
  },
  mounted() {
    const id = this.$route.params.linhmucId
    this.GET_INFO_LINHMUC_UPDATE(id) 
  }
}
</script>