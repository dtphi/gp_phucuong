<template>
  <div class="table-responsive">
    <table
      id="info-lm-thuyen-chuyen-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td class="text-center">TT</td>
          <td class="text-center">CHỨC VỤ</td>
          <td class="text-center">ĐỊA ĐIỂM</td>
          <td class="text-center">THỜI GIAN ĐẾN <br> (ngày tháng năm)</td>
          <td class="text-center">THỜI GIAN ĐI <br> (ngày tháng năm)</td>
          <td class="text-center">{{ $options.setting.info_action_title }}</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, idx) in lists" :key="idx">
          <td>{{ (idx+1) }}</td>
          <td>
            <p class="text-center">{{ item.chucVuName}}</p>
						<div class="text-center">
							<toggle-button class="switch-btn-center" v-if="item.active == 1" :value="switchValue" @change="changeActiveLmThuyenChuyen($event, item)"/>
      				<toggle-button class="switch-btn-center" v-else :value="!switchValue" @change="changeActiveLmThuyenChuyen($event, item)"/>
						</div>	
          </td>
          <td>
            {{ item.diaDiemName }}
          </td>
          <td class="text-right">
            {{ _getTuNgay(item) }}
          </td>
          <td class="text-right">
            {{ _getDenNgay(item) }}
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
	data() {	
		return {
			switchValue: true,
		}
	},
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['removeLmThuyenChuyen', 'updateActiveLmThuyenChuyen']),
    _removeItem(item) {
      const isDl = confirm('Tiếp tục xóa linh mục thuyên chuyển')
      if (isDl) {
        this.removeLmThuyenChuyen({
          action: 'removeLmThuyenChuyen',
          item: item,
        })
      }
    },
    _getTuNgay(item) {
      let ngay = `${item.dia_diem_tu_ngay}/${item.dia_diem_tu_thang}/${item.dia_diem_tu_nam}`
      return ngay.replaceAll('null/', '').replaceAll('null', '')
    },
    _getDenNgay(item) {
      let ngay = `${item.dia_diem_den_ngay}/${item.dia_diem_den_thang}/${item.dia_diem_den_nam}`
      return ngay.replaceAll('null/', '').replaceAll('null', '')
    },
		changeActiveLmThuyenChuyen($event, item) {
          this.updateActiveLmThuyenChuyen({
						item: item,
						action: 'update.active.lm.thuyen.chuyen'
        });
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
