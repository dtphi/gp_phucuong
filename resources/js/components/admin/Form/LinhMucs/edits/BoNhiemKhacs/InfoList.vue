<template>
  <div class="table-responsive">
    <table
      id="info-bo-nhiem-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td class="text-center">TT</td>
          <td class="text-center">CHỨC VỤ</td>
          <td class="text-center">CÔNG VIỆC</td>
          <td class="text-center">TỪ <br> (ngày tháng năm)</td>
          <td class="text-center">ĐẾN <br> (ngày tháng năm)</td>
          <td calss="text-center">{{ $options.setting.info_action_title }}</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, idx) in lists" :key="idx">
          <td>{{ (idx+1) }}</td>
          <td>
            {{ item.chucVuName }}
          </td>
          <td>
            {{ item.cong_viec }}
          </td>
          <td class="text-right">
            {{ item.cong_viec_tu_ngay }}/{{ item.cong_viec_tu_thang }}/{{ item.cong_viec_tu_nam }}
          </td>
          <td class="text-right">
            {{ item.cong_viec_den_ngay }}/{{ item.cong_viec_den_thang }}/{{ item.cong_viec_den_nam }}
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
          <td colspan="4"></td>
          <td class="text-right">
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import BtnAdd from './BtnAdd'
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'

export default {
  name: 'TheInfoList',
  components: {
    BtnAdd,
  },
  props: {
    lists: {
      default() {
        return []
      },
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['removeBoNhiem']),
    _removeItem(item) {
      const isDl = confirm('Tiếp tục xóa bổ nhiệm')
      if (isDl) {
        this.removeBoNhiem({
          action: 'removeBoNhiem',
          item: item,
        })
      }
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
