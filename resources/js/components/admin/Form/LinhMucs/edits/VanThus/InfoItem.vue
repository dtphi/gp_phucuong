<template>
  <tr :key="`show-info-${item.id}`">
    <td>
      <span v-show="!isEdit">{{ item.title }}</span>
      <validation-provider
        v-show="isEdit"
        :name="`item_name${item.id}`"
        rules="required|max:255"
        v-slot="{ errors }"
      >
        <input
          placeholder="Tiêu đề"
          v-model="item.title"
          class="form-control"
          type="text"
        />

        <span class="cms-text-red">{{ errors[0] }}</span>
      </validation-provider>
    </td>
    <td>
      <span v-show="!isEdit">{{ _getTypeText() }}</span>
      <select v-show="isEdit" class="form-control" v-model="item.type">
        <option value="0" :selected="item.type == 0">Dir</option>
        <option value="1" :selected="item.type == 1">File</option>
      </select>
    </td>
    <td>
      <span v-show="!isEdit">{{ item.ghi_chu }}</span>
      <textarea
        v-show="isEdit"
        class="form-control"
        v-model="item.ghi_chu"
      ></textarea>
    </td>
    <td>
      <span v-show="!isEdit">{{ _getStatus() }}</span>
      <select v-show="isEdit" class="form-control" v-model="item.active">
        <option value="1" :selected="item.active == 1">Xảy ra</option>
        <option value="0" :selected="item.active == 0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        v-show="isEdit"
        @click="_updateVanThuForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật văn thư"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-save"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa Văn Thư"
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
import { MODULE_MODULE_LINH_MUC_EDIT } from "store@admin/types/module-types";

export default {
  name: "TheInfoItem",
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
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ["removeVanThu"]),
    _removeItem() {
      this.removeVanThu({
        action: "removeVanThu",
        item: this.item,
      });
    },
    _openEditForm() {
      this.isEdit = !this.isEdit;
    },
    _updateVanThuForm() {
      console.log("update văn thư", this.item);
    },
    _getTypeText() {
      return this.item.type == 0 ? "Dir" : "File";
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
