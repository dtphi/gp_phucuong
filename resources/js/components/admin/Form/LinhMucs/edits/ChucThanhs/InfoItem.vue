<template>
  <tr>
    <td class="text-center">
        <input type="checkbox"
                :id="`info_select_id_${item.id}`"
                v-model="item.isCheck">
    </td>
    <td>
      <span v-show="!isEdit">{{ _getChucThanhText() }}</span>
      <select v-show="isEdit" class="form-control" v-model="item.chuc_thanh_id">
        <option
          :selected="item.chuc_thanh_id == idx"
          :value="idx ? idx : ''"
          v-for="(item, idx) in $options.setting.cf.chucThanhs"
          :key="idx"
        >
          {{ item }}
        </option>
      </select>
    </td>
    <td class="text-center">
      <span v-show="!isEdit">{{ item.label_ngay_thang_nam_chuc_thanh }}</span>
      <cms-date-picker
        v-show="isEdit"
        value-type="format"
        format="YYYY-MM-DD"
        v-model="item.ngay_thang_nam_chuc_thanh"
        type="date"
      ></cms-date-picker>
    </td>
    <td>
      <span v-show="!isEdit">{{ item.noi_thu_phong }}</span>
      <input
        v-show="isEdit"
        type="text"
        class="form-control"
        placeholder="Nơi thụ phong"
        v-model="item.noi_thu_phong"
      />
    </td>
    <td>
      <span v-show="!isEdit">{{ item.nguoi_thu_phong }}</span>
      <input
        v-show="isEdit"
        type="text"
        class="form-control"
        placeholder="Người thụ phong"
        v-model="item.nguoi_thu_phong"
      />
    </td>
    <td>
      <span v-show="!isEdit">{{ item.ghi_chu }}</span>
      <textarea
        v-show="isEdit"
        class="form-control"
        v-model="item.ghi_chu"
      ></textarea>
    </td>
    <td>
      <span v-show="!isEdit">{{ _getStatus() }}</span>
      <select v-show="isEdit" class="form-control" v-model="item.active">
        <option value="1" :selected="item.active == 1">Xảy ra</option>
        <option value="0" :selected="item.active == 0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        v-show="isEdit"
        @click="_updateChucThanhForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật chức thánh"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-edit"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa chức thánh"
        class="btn btn-default cms-btn"
      >
        <i
          class="fa"
          :class="isEdit ? 'fa-angle-double-up' : 'fa-angle-double-down'"
        ></i>
      </button>
      <button
        type="button"
        @click="_removeItem()"
        data-toggle="tooltip"
        class="btn btn-default cms-btn"
      >
        <font-awesome-layers size="1x" style="background: MistyRose">
          <font-awesome-icon icon="circle" style="color: Tomato" />
          <font-awesome-icon
            icon="times"
            class="fa-inverse"
            transform="shrink-4"
          />
        </font-awesome-layers>
      </button>
    </td>
  </tr>
</template>

<script>
import { config } from "@app/common/config";
import { mapActions } from "vuex";
import { MODULE_MODULE_LINH_MUC_EDIT } from "store@admin/types/module-types";

export default {
  name: "TheInfoItem",
  props: {
    item: {
      default: {},
    },
  },
  data() {
    return {
      isEdit: false,
    };
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ["removeChucThanh", "addChucThanhs"]),
    _removeItem() {
      this.removeChucThanh({
        action: "removeChucThanh",
        item: this.item,
      });
    },
    _openEditForm() {
      this.isEdit = !this.isEdit;
    },
    _updateChucThanhForm() {
      if (this.item.id) {
        this.addChucThanhs({
          action: 'create.update.chuc.thanh.db',
          info: this.item
        });
      }
    },
    _getChucThanhText() {
      let chucThanh = "Pho tế";
      if (this.item.chuc_thanh_id == 2) chucThanh = "Linh mục";
      if (this.item.chuc_thanh_id == 3) chucThanh = "Giám mục";
      return chucThanh;
    },
    _getStatus() {
      return this.item.active == 1 ? "Xảy ra" : "Ẩn";
    },
  },
  setting: {
    cf: config,
    info_action_title: "Thực hiện"
  },
};
</script>
