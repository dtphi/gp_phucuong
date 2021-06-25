<template>
  <button
    type="button"
    data-toggle="tooltip"
    @click="_addInfo()"
    title="Thêm giáo xứ"
    class="btn btn-default cms-btn"
  >
    <font-awesome-layers style="background: honeydew">
      <font-awesome-icon size="1x" icon="plus" />
    </font-awesome-layers>
  </button>
</template>

<script>
import { mapActions } from "vuex";
import { MODULE_MODULE_GIAO_PHAN_ADD } from "store@admin/types/module-types";

export default {
  name: "TheButtonAdd",
  props: {
    giaoHat: {
      default: null,
    }
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, ["addHatXuGiaoPhan"]),

    _addInfo() {
      this.addHatXuGiaoPhan({
        action: "addHatXuGiaoPhan",
        giaoHat: this.giaoHat,
      });
    },
  },
};
</script>
