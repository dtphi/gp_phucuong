<template>
  <tr>
    <td class="text-center">
        <input type="checkbox"
                :id="`info_select_id_${item.id}`"
                v-model="item.isCheck">
    </td>
    <td class="text-center">
      <info-ban-chuyen-trach-autocomplete
        :ban-chuyen-trach="item"
        :key="item.id"
      ></info-ban-chuyen-trach-autocomplete>
      <span class="cms-text-red">{{ _getErrorBanChuyenTrachSelect }}</span>
    </td>
    <td>
      <select v-model="item.active" id="input-info-active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addBanChuyenTrachForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật ban chuyên trách"
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
import { MODULE_MODULE_GIAO_PHAN_EDIT } from "store@admin/types/module-types";
import InfoBanChuyenTrachAutocomplete from "../Groups/InfoBanChuyenTrachAutocomplete";

export default {
  name: "TheInfoNewItem",
  components: {
    InfoBanChuyenTrachAutocomplete,
  },
  props: {
    item: {
      default: {},
    },
  },
  computed: {
    _getErrorBanChuyenTrachSelect() {
      if (this.item.ban_chuyen_trach_id) {
        return null
      }

      return 'Chọn ban chuyên trách';
    }
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
    _addBanChuyenTrachForm() {
      if (this.item.ban_chuyen_trach_id) {
        this.ACTION_UPDATE_DROPDOWN_BANCHUYENTRACH_LIST({
          action: 'create.update.ban.chuyen.trach.db',
          banChuyenTrach: this.item
        });
      }
    },
  },
  setting: {
    info_action_title: "Thực hiện",
  },
};
</script>
