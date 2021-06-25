<template>
  <tbody>
    <tr>
      <td>
        <info-cong-doan-tu-si-autocomplete
          :hat="hat"
          :hat-cong-dts="item"
          :key="item.id"
        ></info-cong-doan-tu-si-autocomplete>
      </td>
      <td>
        <select
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
  </tbody>
</template>

<script>
import { mapActions } from "vuex";
import BtnAdd from "./BtnAdd";
import { MODULE_MODULE_GIAO_PHAN_ADD } from "store@admin/types/module-types";
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
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, [
      "removeHatCongDoanTuSiGiaoPhan",
    ]),
    _removeItem() {
      this.removeHatCongDoanTuSiGiaoPhan({
        action: "removeHatCongDoanTuSiGiaoPhan",
        giaoHat: this.hat,
        congDoanTuSi: this.item,
      });
    },
  },
  setting: {
    info_action_title: "Thực hiện"
  },
};
</script>
