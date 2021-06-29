<template>
  <tr>
    <td>
      <span v-show="!isEdit">{{ item.hatName }}</span>
      <info-giao-hat-autocomplete
        v-show="isEdit"
        :hat="item"
        :key="item.id"
      ></info-giao-hat-autocomplete>
    </td>
    <td>
      <span v-show="!isEdit">{{ _getStatus() }}</span>
      <select
        v-show="isEdit"
        id="input-info-active"
        v-model="item.active"
        class="form-control"
      >
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        v-show="isEdit"
        @click="_updateHatForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật giáo hạt"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-edit"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa giáo hạt"
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
import InfoGiaoHatAutocomplete from "../Groups/InfoGiaoHatAutocomplete";

export default {
  name: "TheInfoItem",
  components: {
    InfoGiaoHatAutocomplete,
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
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["removeHatGiaoPhan", "ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST"]),
    _removeItem() {
      this.removeHatGiaoPhan({
        action: "removeHatGiaoPhan",
        item: this.item,
      });
    },
    _openEditForm() {
      this.isEdit = !this.isEdit;
    },
    _updateHatForm() {
      if (this.item.giao_hat_id) {
        this.ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST({
          action: 'create.update.hat.db',
          hat: this.item
        });
      }
    },
    _getStatus() {
      return this.item.active == 1 ? "Xảy ra" : "Ẩn";
    },
  }
};
</script>
