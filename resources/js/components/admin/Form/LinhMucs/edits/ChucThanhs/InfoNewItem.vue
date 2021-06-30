<template>
  <tr>
    <td class="text-center">
        <input type="checkbox" name="selected[]"
                :id="`info_select_id_${item.id}`"
                :value="item.id">
    </td>
    <td>
      <validation-provider
        :name="`item_name${item.id}`"
        rules="required"
        v-slot="{ errors }"
      >
        <select class="form-control" v-model="item.chuc_thanh_id">
          <option
            :selected="item.chuc_thanh_id == idx"
            :value="idx ? idx : ''"
            v-for="(item, idx) in $options.setting.cf.chucThanhs"
            :key="idx"
          >
            {{ item }}
          </option>
        </select>
        <span class="cms-text-red">{{ errors[0] }}</span>
      </validation-provider>
    </td>
    <td class="text-center">
      <cms-date-picker
        value-type="format"
        format="YYYY-MM-DD"
        v-model="item.ngay_thang_nam_chuc_thanh"
        type="date"
      ></cms-date-picker>
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        placeholder="Nơi thụ phong"
        v-model="item.noi_thu_phong"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        placeholder="Người thụ phong"
        v-model="item.nguoi_thu_phong"
      />
    </td>
    <td>
      <textarea class="form-control" v-model="item.ghi_chu"></textarea>
    </td>
    <td>
      <select class="form-control" v-model="item.active">
        <option value="1" :selected="item.active == 1">Xảy ra</option>
        <option value="0" :selected="item.active == 0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addChucThanhForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật chức thánh"
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
import { config } from "@app/common/config";
import { mapActions } from "vuex";
import { MODULE_MODULE_LINH_MUC_EDIT } from "store@admin/types/module-types";

export default {
  name: "TheInfoNewItem",
  props: {
    item: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ["removeChucThanh", "addChucThanhs"]),
    _removeItem() {
      this.removeChucThanh({
        action: "removeChucThanh",
        item: this.item,
      });
    },
    _addChucThanhForm() {
      if (this.item.id) {
        this.addChucThanhs({
          action: 'create.update.chuc.thanh.db',
          info: this.item
        });
      }
    },
  },
  setting: {
    cf: config,
    info_action_title: "Thực hiện"
  },
};
</script>
