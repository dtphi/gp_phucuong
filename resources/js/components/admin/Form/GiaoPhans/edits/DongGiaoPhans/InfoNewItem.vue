<template>
  <tr>
    <td class="text-center">
      <input
        type="checkbox"
        :id="`info_select_id_${item.id}`"
        v-model="item.isCheck"
      />
    </td>
    <td class="text-center">
      <info-dong-autocomplete :dong="item"></info-dong-autocomplete>
    </td>
    <td>
      <select v-model="item.active" id="input-info-active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addDongForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật dòng"
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
import { mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_PHAN_EDIT, } from 'store@admin/types/module-types'
import InfoDongAutocomplete from '../Groups/InfoDongAutocomplete'

export default {
  name: 'TheInfoNewItem',
  components: {
    InfoDongAutocomplete,
  },
  props: {
    item: {
      default: {},
    },
  },
  computed: {
    _getErrorDongSelect() {
      if (this.item.dong_id) {
        return null
      }

      return 'Chọn dòng'
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      'removeDongGiaoPhan',
      'ACTION_UPDATE_DROPDOWN_DONG_LIST'
    ]),
    _removeItem() {
      this.removeDongGiaoPhan({
        action: 'removeDongGiaoPhan',
        item: this.item,
      })
    },
    _addDongForm() {
      if (this.item.dong_id) {
        this.ACTION_UPDATE_DROPDOWN_DONG_LIST({
          action: 'create.update.dong.db',
          dong: this.item,
        })
      }
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
