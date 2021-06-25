<template>
  <tr>
    <td>
      <validation-provider
        :name="`item_name${item.id}`"
        rules="required|max:255"
        v-slot="{ errors }"
      >
        <input
          placeholder="Tên bằng cấp"
          v-model="item.name"
          class="form-control"
          type="text"
        />

        <span class="cms-text-red">{{ errors[0] }}</span>
      </validation-provider>
    </td>
    <td>
      <validation-provider
        :name="`item_name${item.id}`"
        rules="max:500"
        v-slot="{ errors }"
      >
        <textarea class="form-control" v-model="item.ghi_chu"></textarea>

        <span class="cms-text-red">{{ errors[0] }}</span>
      </validation-provider>
    </td>
    <td>
      <select class="form-control" v-model="item.type">
        <option value="0" :selected="item.type == 0">Loại 1</option>
        <option value="1" :selected="item.type == 1">Loại 2</option>
      </select>
    </td>
    <td>
      <select class="form-control" v-model="item.active">
        <option value="1" :selected="item.active == 1">Xảy ra</option>
        <option value="0" :selected="item.active == 0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addBangCapForm()"
        type="button"
        data-toggle="tooltip"
        title="Thêm bằng cấp"
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
import { MODULE_MODULE_LINH_MUC_EDIT } from "store@admin/types/module-types";

export default {
  name: "TheInfoNewItem",
  props: {
    item: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ["removeBangCap"]),
    _removeItem() {
      this.removeBangCap({
        action: "",
        item: this.item,
      });
    },
    _addBangCapForm() {
      console.log("add bang cap", this.item);
    },
  },
  setting: {
    info_action_title: "Thực hiện",
  },
};
</script>
