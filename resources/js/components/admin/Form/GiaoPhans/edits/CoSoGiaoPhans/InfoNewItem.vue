<template>
  <tr>
    <td class="text-center">
        <input type="checkbox"
                :id="`info_select_id_${item.id}`"
                v-model="item.isCheck">
    </td>
    <td class="text-center">
      <info-co-so-giao-phan-autocomplete
        :coso="item"
        :key="item.id"
      ></info-co-so-giao-phan-autocomplete>
    </td>
    <td>
      <select v-model="item.active" id="input-info-active" class="form-control">
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        @click="_addCoSoForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật cơ sở"
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
import InfoCoSoGiaoPhanAutocomplete from '../Groups/InfoCoSoGiaoPhanAutocomplete'

export default {
  name: 'TheInfoNewItem',
  components: {
    InfoCoSoGiaoPhanAutocomplete,
  },
  props: {
    item: {
      default: {},
    },
  },
  computed: {
    _getErrorCoSoSelect() {
      if (this.item.co_so_giao_phan_id) {
        return null
      }

      return 'Chọn cơ sở'
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, ['removeCoSoGiaoPhan', 'ACTION_UPDATE_DROPDOWN_COSO_LIST']),
    _removeItem() {
      this.removeCoSoGiaoPhan({
        action: 'removeCoSoGiaoPhan',
        item: this.item,
      })
    },
    _addCoSoForm() {
      if (this.item.co_so_giao_phan_id) {
        this.ACTION_UPDATE_DROPDOWN_COSO_LIST({
          action: 'create.update.co.so.db',
          coso: this.item,
        })
      }
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
