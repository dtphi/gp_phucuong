<template>
  <tr>
    <td>
      <span v-show="!isEdit">{{ item.cosoName }}</span>
      <info-co-so-giao-phan-autocomplete
        v-show="isEdit"
        :coso="item"
        :key="item.id"
      ></info-co-so-giao-phan-autocomplete>
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
        @click="_updateCoSoForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật cơ sở"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-save"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa cơ sở"
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
import { MODULE_MODULE_GIAO_PHAN_EDIT } from "store@admin/types/module-types";
import InfoCoSoGiaoPhanAutocomplete from "../Groups/InfoCoSoGiaoPhanAutocomplete";

export default {
  name: "TheInfoList",
  components: {
    InfoCoSoGiaoPhanAutocomplete,
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
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["removeCoSoGiaoPhan"]),
    _removeItem() {
      this.removeCoSoGiaoPhan({
        action: "removeCoSoGiaoPhan",
        item: this.item,
      });
    },
    _openEditForm() {
      this.isEdit = !this.isEdit;
    },
    _updateCoSoForm() {
      console.log("update co so", this.item);
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
