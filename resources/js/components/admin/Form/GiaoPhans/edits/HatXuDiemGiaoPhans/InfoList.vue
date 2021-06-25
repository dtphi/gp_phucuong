<template>
  <div class="table-responsive">
    <table
      id="info-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover"
      v-for="(item, idx) in lists"
      :key="idx"
    >
      <thead>
        <tr>
          <td colspan="3">
            {{ item.id }}
          </td>
        </tr>
        <tr>
          <td class="text-left">Giáo xứ</td>
          <td class="text-left">Trình trạng</td>
          <td class="text-right">Thực hiện</td>
        </tr>
      </thead>
      <tbody v-for="(giaoDiem, idx) in item.giao_xu_diems" :key="idx">
        <tr>
          <td>
            <info-giao-diem-autocomplete></info-giao-diem-autocomplete>
          </td>
          <td>
            <select id="input-info-active" class="form-control">
              <option value="1" selected="selected">Xảy ra</option>
              <option value="0">Ẩn</option>
            </select>
          </td>
          <td class="text-right">
            <button
              type="button"
              @click="_removeItem(item, giaoDiem)"
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
      </tbody>

      <tfoot>
        <tr>
          <td colspan="3" class="text-right">
            <btn-add :giao-xu="item"></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import BtnAdd from "./BtnAdd";
import { MODULE_MODULE_GIAO_PHAN_EDIT } from "store@admin/types/module-types";
import InfoGiaoDiemAutocomplete from "../Groups/InfoGiaoDiemAutocomplete";

export default {
  name: "TheInfoList",
  components: {
    BtnAdd,
    InfoGiaoDiemAutocomplete,
  },
  props: {
    lists: {
      default: {},
    },
  },
  computed: {},
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ["removeHatXuDiemGiaoPhan"]),
    _removeItem(item, giaoDIem) {
      this.removeHatXuDiemGiaoPhan({
        action: "removeHatXuDiemGiaoPhan",
        giaoXu: item,
        giaoDiem: giaoDIem,
      });
    },
  },
  setting: {
    info_title: "Tiêu đề",
    info_url_title: "Url tiêu đề",
    info_author_titile: "Tác giả",
    info_sort_order_title: "Sắp xếp",

    info_action_title: "Thực hiện",
    btn_image_sub_remove_txt: "Xóa",
    btn_image_sub_add_txt: "Thêm hình ảnh",
  },
};
</script>
