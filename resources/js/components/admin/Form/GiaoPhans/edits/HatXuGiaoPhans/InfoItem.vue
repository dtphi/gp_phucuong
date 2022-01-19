<template>
  <tr>
    <td>{{ no }}</td>
    <td class="text-center">
      <input
        type="checkbox"
        :id="`info_select_id_${item.id}`"
        v-model="item.isCheck"
      />
    </td>
    <td>
      <a :href="item.hrefGiaoXu"
        ><span v-show="!isEdit">{{ item.hatXuName }}</span></a
      >
      <info-giao-xu-autocomplete
        v-show="isEdit"
        :hat="hat"
        :hat-xu="item"
        :key="item.id"
      ></info-giao-xu-autocomplete>
    </td>
    <td>
      <span v-show="!isEdit">{{ _getStatus() }}</span>
      <select
        v-show="isEdit"
        v-model="item.active"
        id="input-info-active"
        class="form-control"
      >
        <option value="1" selected="selected">Xảy ra</option>
        <option value="0">Ẩn</option>
      </select>
    </td>
    <td class="text-right">
      <button
        v-show="isEdit"
        @click="_updateXuForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật giáo xứ"
        class="btn btn-primary cms-btn"
      >
        <i class="fa fa-edit"></i>
      </button>
      <button
        @click="_openEditForm"
        type="button"
        data-toggle="tooltip"
        title="Sửa giáo xứ"
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
import { mapActions, } from 'vuex'
import { MODULE_MODULE_GIAO_PHAN_EDIT, } from 'store@admin/types/module-types'
import InfoGiaoXuAutocomplete from '../Groups/InfoGiaoXuAutocomplete'

export default {
  name: 'TheInfoList',
  components: {
    InfoGiaoXuAutocomplete,
  },
  props: {
    no: {
      default() {
        return 0
      }
    },
    hat: {
      default: {},
    },
    item: {
      default: {},
    },
  },
  data() {
    return {
      isEdit: false,
    }
  },
  methods: {
    ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
      'removeHatXuGiaoPhan',
      'ACTION_UPDATE_DROPDOWN_GIAO_HAT_XU_LIST'
    ]),
    _removeItem() {
      this.removeHatXuGiaoPhan({
        action: 'removeHatXuGiaoPhan',
        giaoHat: this.hat,
        giaoXu: this.item,
      })
    },
    _openEditForm() {
      this.isEdit = !this.isEdit
    },
    _updateXuForm() {
      this.ACTION_UPDATE_DROPDOWN_GIAO_HAT_XU_LIST({
        action: 'create.update.hat.xu.db',
        hat: this.hat,
        hatXu: this.item,
      })
    },
    _getStatus() {
      return this.item.active == 1 ? 'Xảy ra' : 'Ẩn'
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
