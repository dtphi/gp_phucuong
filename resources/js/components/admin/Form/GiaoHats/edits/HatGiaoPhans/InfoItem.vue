<template>
    <tr>
        <td>
            <info-giao-hat-autocomplete :hat="item" :key="item.id"></info-giao-hat-autocomplete>
        </td>
        <td>
            <select
                id="input-info-active"
                v-model="item.active"
                class="form-control">
                <option value="1" selected="selected">Xảy ra</option>
                <option value="0">Ẩn</option>
            </select>
        </td>
        <td class="text-right">
            <button 
                type="button" 
                @click="_removeItem()"
                data-toggle="tooltip"
                class="btn btn-default cms-btn">
                    <font-awesome-layers size="1x" style="background:MistyRose">
                        <font-awesome-icon icon="circle" style="color:Tomato"/>
                        <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                    </font-awesome-layers>
            </button>
        </td>
    </tr>
</template>

<script>
import {
  mapActions,
} from 'vuex'
import {
  MODULE_MODULE_GIAO_PHAN_EDIT,
} from 'store@admin/types/module-types'
import InfoGiaoHatAutocomplete from '../Groups/InfoGiaoHatAutocomplete'

export default {
  name: 'TheInfoItem',
  components: {
    InfoGiaoHatAutocomplete,
  },
  props: {
    item: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      'removeHatGiaoPhan'
    ]),
    _removeItem() {
      this.removeHatGiaoPhan({
        action: 'removeHatGiaoPhan',
        item: this.item,
      })
    },
  },
  setting: {
    info_title: 'Tiêu đề',
    info_url_title: 'Url tiêu đề',
  },
}
</script>
