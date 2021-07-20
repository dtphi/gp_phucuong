<template>
  <tr>
    <td class="text-center">
        <input type="checkbox"
                :id="`info_select_id_${item.id}`"
                v-model="item.isCheck">
    </td>
    <td class="text-center">
      <info-giao-xu-autocomplete
        :hat="hat"
        :hat-xu="item"
        :key="item.id"
      ></info-giao-xu-autocomplete>
    </td>
    <td>
      <select v-model="item.active" id="input-info-active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button v-show="hat.giao_hat_id && hat.isEdit"
        @click="_addXuForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật giáo xứ"
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
import InfoGiaoXuAutocomplete from "../Groups/InfoGiaoXuAutocomplete";

export default {
  name: "TheInfoNewList",
  components: {
    BtnAdd,
    InfoGiaoXuAutocomplete,
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
    _getErrorGiaoXuSelect() {
      if (this.item.giao_xu_id) {
        return null
      }

      return 'Chọn giáo xứ';
    }
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["removeHatXuGiaoPhan", "ACTION_UPDATE_DROPDOWN_GIAO_HAT_XU_LIST"]),
    _removeItem() {
      this.removeHatXuGiaoPhan({
        action: "removeHatXuGiaoPhan",
        giaoHat: this.hat,
        giaoXu: this.item,
      });
    },
    _addXuForm() {
      if (this.item.giao_xu_id && this.hat.giao_hat_id) {
        this.ACTION_UPDATE_DROPDOWN_GIAO_HAT_XU_LIST({
          action: 'create.update.hat.xu.db',
          hat: this.hat,
          hatXu: this.item
        });
      }
    },
  },
  setting: {
    info_action_title: "Thực hiện",
  },
};
</script>
