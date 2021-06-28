<template>
  <tr>
    <td>
      <info-cong-doan-tu-si-autocomplete
        :hat="hat"
        :hat-cong-dts="item"
        :key="item.id"
      ></info-cong-doan-tu-si-autocomplete>
      <span class="cms-text-red">{{ _getErrorCongdtsSelect }}</span>
    </td>
    <td>
      <select v-model="item.active" id="input-info-active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addCongdtsForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật công đoàn tu sĩ"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-save"></i>
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
  name: "TheInfoNewItem",
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
  computed: {
    _getErrorCongdtsSelect() {
      if (this.item.cong_doan_tu_si_id) {
        return null
      }

      return 'Chọn công đoàn tu sĩ';
    }
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
    _addCongdtsForm() {
      if (this.item.cong_doan_tu_sis && this.hat.giao_hat_id) {
        this.ACTION_UPDATE_DROPDOWN_GIAO_HAT_CONGDTS_LIST({
          action: 'create.update.hat.congdts.db',
          hat: this.hat,
          hatCongDts: this.item
        });
      }
    },
  },
  setting: {
    info_action_title: "Thực hiện"
  },
};
</script>
