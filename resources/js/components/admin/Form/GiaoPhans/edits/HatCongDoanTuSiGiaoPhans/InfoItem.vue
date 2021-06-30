<template>
  <tr>
    <td class="text-center">
        <input type="checkbox" name="selected[]"
                :id="`info_select_id_${item.id}`"
                :value="item.id">
    </td>
    <td>
      <span v-show="!isEdit">{{ item.hatCongDtsName }}</span>
      <info-cong-doan-tu-si-autocomplete
        v-show="isEdit"
        :hat="hat"
        :hat-cong-dts="item"
        :key="item.id"
      ></info-cong-doan-tu-si-autocomplete>
    </td>
    <td>
      <span v-show="!isEdit">{{ _getStatus() }}</span>
      <select
        v-show="isEdit"
        v-model="item.active"
        id="input-info-active"
        class="form-control"
      >
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        v-show="isEdit"
        @click="_updateCongdtsForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật công đoàn tu sĩ"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-edit"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa công đoàn tu sĩ"
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
import { mapActions } from "vuex";
import BtnAdd from "./BtnAdd";
import { MODULE_MODULE_GIAO_PHAN_EDIT } from "store@admin/types/module-types";
import InfoCongDoanTuSiAutocomplete from "../Groups/InfoCongDoanTuSiAutocomplete";

export default {
  name: "TheInfoList",
  components: {
    BtnAdd,
    InfoCongDoanTuSiAutocomplete,
  },
  props: {
    hat: {
      default: {},
    },
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
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      "removeHatCongDoanTuSiGiaoPhan","ACTION_UPDATE_DROPDOWN_GIAO_HAT_CONGDTS_LIST"
    ]),
    _removeItem() {
      this.removeHatCongDoanTuSiGiaoPhan({
        action: "removeHatCongDoanTuSiGiaoPhan",
        giaoHat: this.hat,
        congDoanTuSi: this.item,
      });
    },
    _openEditForm() {
      this.isEdit = !this.isEdit;
    },
    _updateCongdtsForm() {
      this.ACTION_UPDATE_DROPDOWN_GIAO_HAT_CONGDTS_LIST({
        action: 'create.update.hat.congdts.db',
        hat: this.hat,
        hatCongDts: this.item
      });
    },
    _getStatus() {
      return this.item.active == 1 ? "Xảy ra" : "Ẩn";
    },
  },
  setting: {
    info_action_title: "Thực hiện",
  },
};
</script>
