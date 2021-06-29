<template>
  <tr>
    <td>
      <span v-show="!isEdit">{{ item.dongName }}</span>
      <info-dong-autocomplete
        v-show="isEdit"
        :dong="item"
        :key="item.id"
      ></info-dong-autocomplete>
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
        @click="_updateDongForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật dòng"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-edit"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa dòng"
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
import InfoDongAutocomplete from "../Groups/InfoDongAutocomplete";

export default {
  name: "TheInfoList",
  components: {
    BtnAdd,
    InfoDongAutocomplete,
  },
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
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["removeDongGiaoPhan"]),
    _removeItem() {
      this.removeDongGiaoPhan({
        action: "removeDongGiaoPhan",
        item: this.item,
      });
    },
    _openEditForm() {
      this.isEdit = !this.isEdit;
    },
    _updateDongForm() {
      console.log("update dong", this.item);
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
