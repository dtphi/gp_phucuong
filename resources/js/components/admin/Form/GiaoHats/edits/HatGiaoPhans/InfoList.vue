<template>
    <div class="table-responsive">
        <table id="info-hat-giao-phan-list" 
            class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">Hạt</td>
                    <td class="text-left">Trình trạng</td>
                    <td class="text-right">{{$options.setting.info_action_title}}</td>
                </tr>
            </thead>
            <tbody>
                <info-item v-for="(item, idx) in lists" :key="idx" :item="item" ></info-item>
            </tbody>

            <tfoot>
                <tr>
                    <td></td><td></td>
                    <td class="text-right">
                        <btn-add></btn-add>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>    
</template>

<script>
import {
  mapActions,
} from 'vuex'
import BtnAdd from './BtnAdd'
import {
  MODULE_MODULE_GIAO_PHAN_EDIT,
} from 'store@admin/types/module-types'
import InfoItem from './InfoItem'

export default {
  name: 'TheInfoList',
  components: {
    BtnAdd,
    InfoItem,
  },
  props: {
    lists: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      'removeHatGiaoPhan'
    ]),
    _removeItem(item) {
      this.removeHatGiaoPhan({
        action: 'removeHatGiaoPhan',
        item: item,
      })
    },
  },
  setting: {
    info_title: 'Tiêu đề',
    info_url_title: 'Url tiêu đề',
    info_author_titile: 'Tác giả',
    info_sort_order_title: 'Sắp xếp',
            
    info_action_title: 'Thực hiện',
    btn_image_sub_remove_txt: 'Xóa',
    btn_image_sub_add_txt: 'Thêm hình ảnh',
  },
}
</script>
