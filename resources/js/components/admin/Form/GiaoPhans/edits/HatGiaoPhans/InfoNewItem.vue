<template>
  <tr>
    <td class="text-center">
        <input type="checkbox" name="selected[]"
                :id="`info_select_id_${item.id}`"
                :value="item.id">
    </td>
    <td class="text-center">
      <info-giao-hat-autocomplete
        :hat="item"
        :key="item.id"
      ></info-giao-hat-autocomplete>
      <span class="cms-text-red">{{ _getErrorGiaoHatSelect }}</span>
    </td>
    <td>
      <select id="input-info-active" v-model="item.active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addHatForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật giáo hạt"
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
import InfoGiaoHatAutocomplete from "../Groups/InfoGiaoHatAutocomplete";

export default {
  name: "TheInfoNewItem",
  components: {
    InfoGiaoHatAutocomplete,
  },
  props: {
    item: {
      default: {},
    },
  },
  data () {
    return {
      error_giao_hat_select: null
    }
  },
  computed: {
    _getErrorGiaoHatSelect() {
      if (this.item.giao_hat_id) {
        return null
      }

      return 'Chọn giáo hạt';
    }
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["removeHatGiaoPhan", "ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST"]),
    _removeItem() {
      this.removeHatGiaoPhan({
        action: "removeHatGiaoPhan",
        item: this.item,
      });
    },
    _addHatForm() {
      if (this.item.giao_hat_id) {
        this.ACTION_UPDATE_DROPDOWN_GIAO_HAT_LIST({
          action: 'create.update.hat.db',
          hat: this.item
        });
      }
    },
  }
};
</script>
