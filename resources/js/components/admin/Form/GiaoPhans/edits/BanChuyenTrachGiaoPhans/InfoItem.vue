<template>
  <tr>
    <td class="text-center">
        <input type="checkbox" name="selected[]"
                :id="`info_select_id_${item.id}`"
                :value="item.id">
    </td>
    <td>
      <span v-show="!isEdit">{{ item.banChuyenTrachName }}</span>
      <info-ban-chuyen-trach-autocomplete
        v-show="isEdit"
        :ban-chuyen-trach="item"
        :key="item.id"
      ></info-ban-chuyen-trach-autocomplete>
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
        @click="_updateBanChuyenTrachForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật ban chuyên trách"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-edit"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa ban chuyên trách"
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
import InfoBanChuyenTrachAutocomplete from "../Groups/InfoBanChuyenTrachAutocomplete";

export default {
  name: "TheInfoItem",
  components: {
    InfoBanChuyenTrachAutocomplete,
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
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      "removeBanChuyenTrachGiaoPhan","ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST"
    ]),
    _removeItem() {
      this.removeBanChuyenTrachGiaoPhan({
        action: "removeBanChuyenTrachGiaoPhan",
        item: this.item,
      });
    },
    _openEditForm() {
      this.isEdit = !this.isEdit;
    },
    _updateBanChuyenTrachForm() {
      if (this.item.ban_chuyen_trach_id) {
        this.ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST({
          action: 'create.update.ban.chuyen.trach.db',
          banChuyenTrach: this.item
        });
      }
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
