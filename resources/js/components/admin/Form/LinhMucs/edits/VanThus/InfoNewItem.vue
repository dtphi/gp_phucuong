<template>
  <tr>
    <td class="text-center">
        <input type="checkbox"
                :id="`info_select_id_${item.id}`"
                v-model="item.isCheck">
    </td>
    <td>
      <validation-provider
        :name="`item_name${item.id}`"
        rules="max:255"
        v-slot="{ errors }"
      >
        <input
          placeholder="Tiêu đề"
          v-model="item.title"
          class="form-control"
          type="text"
        />

        <span class="cms-text-red">{{ errors[0] }}</span>
      </validation-provider>
    </td>
    <td>
      <select class="form-control" v-model="item.type">
        <option value="0" :selected="item.type == 0">Dir</option>
        <option value="1" :selected="item.type == 1">File</option>
      </select>
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
    <td class="text-right">
      <button
        @click="_addVanThuForm()"
        type="button"
        data-toggle="tooltip"
        title="Cập nhật văn thư"
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
import { MODULE_MODULE_LINH_MUC_EDIT, } from 'store@admin/types/module-types'

export default {
  name: 'TheInfoNewItem',
  props: {
    item: {
      default: {},
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['removeVanThu', 'addVanThus']),
    _removeItem() {
      this.removeVanThu({
        action: 'removeVanThu',
        item: this.item,
      })
    },
    _addVanThuForm() {
      if (this.item.id) {
        this.addVanThus({
          action: 'create.update.van.thu.db',
          info: this.item,
        })
      }
    },
  },
}
</script>
