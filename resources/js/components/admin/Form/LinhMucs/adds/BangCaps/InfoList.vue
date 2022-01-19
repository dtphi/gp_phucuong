<template>
  <div class="table-responsive">
    <table
      id="info-bang-cap-list"
      class="table table-striped table-bordered table-hover"
    >
      <thead>
        <tr>
          <td style="width: 40%" class="text-left">Tên bằng</td>
          <td style="width: 30%" class="text-left">Ghi chú</td>
          <td style="width: 10%" class="text-left">Loại</td>
          <td style="width: 10%" class="text-left">Tình trạng</td>
          <td style="width: 10%" class="text-right">
            {{ $options.setting.info_action_title }}
          </td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, idx) in lists" :key="idx">
          <td>
            <validation-provider
              :name="`item_name${item.id}`"
              rules="max:255"
              v-slot="{ errors }"
            >
              <input
                placeholder="Tên bằng cấp"
                v-model="item.name"
                class="form-control"
                type="text"
              />

              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </td>
          <td>
            <validation-provider
              :name="`item_name${item.id}`"
              rules="max:500"
              v-slot="{ errors }"
            >
              <textarea class="form-control" v-model="item.ghi_chu"></textarea>

              <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
          </td>
          <td>
            <select class="form-control" v-model="item.type">
              <option value="0" :selected="item.type == 0">Loại 1</option>
              <option value="1" :selected="item.type == 1">Loại 2</option>
            </select>
          </td>
          <td>
            <select class="form-control" v-model="item.active">
              <option value="1" :selected="item.active == 1">Xảy ra</option>
              <option value="0" :selected="item.active == 0">Ẩn</option>
            </select>
          </td>
          <td class="text-right">
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
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_ADD, ['removeBangCap']),
    _removeItem(item) {
      this.removeBangCap({
        action: '',
        item: item,
      })
    },
  },
  setting: {
    info_action_title: 'Thực hiện',
  },
}
</script>
