<template>
  <div>
    <table
      id="info-chuc-thanh-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td class="text-left">Chức thánh</td>
          <td class="text-left">Ngày tháng</td>
          <td class="text-left">Nơi thụ phong</td>
          <td class="text-left">Người thụ phong</td>
          <td class="text-left">Ghi chú</td>
          <td class="text-left">Trình trang</td>
          <td calss="text-right">{{ $options.setting.info_action_title }}</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, idx) in lists" :key="idx">
          <td>
            <select class="form-control" v-model="item.chuc_thanh_id">
              <option
                :selected="item.chuc_thanh_id == idx"
                :value="idx"
                v-for="(item, idx) in $cmsCfg.chucThanhs"
                :key="idx"
              >
                {{ item }}
              </option>
            </select>
          </td>
          <td>
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
          <td>
            <button
              type="button"
              @click="_removeItem(item)"
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
          <td colspan="6"></td>
          <td class="text-right">
            <btn-add></btn-add>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import BtnAdd from './BtnAdd'
import { MODULE_MODULE_LINH_MUC_ADD, } from 'store@admin/types/module-types'

export default {
  name: 'TheInfoList',
  components: {
    BtnAdd,
  },
  props: {
    lists: {
      default: {},
    },
  },
  computed: {},
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_ADD, ['removeChucThanh']),
    _removeItem(item) {
      this.removeChucThanh({
        action: 'removeChucThanh',
        item: item,
      })
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
