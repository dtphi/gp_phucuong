<template>
  <tr>
    <td>{{ _getNo() }}</td>
    <td class="text-center">
      <input
        type="checkbox"
        name="selected[]"
        :id="`info_select_id_${info.id}`"
        :value="info.id"
      />
    </td>
    <td class="text-left">{{ _getTen() }}</td>
    <td class="text-center" style="width: 7%">
      <img :src="info.imgThum" class="img-thumbnail" />
    </td>
    <td class="text-center">{{ info.phone }}</td>
    <td class="text-center">{{ info.email }}</td>
    <td class="text-center">
      {{ $helper.fn_format_dd_mm_yyyy(info.ngay_sinh) }}
    </td>
    <td class="text-center">{{ info.trieu_dong }}</td>
    <td class="text-center">{{ info.active }}</td>
    <td class="text-right">
      <btn-edit :info-id="info.id"></btn-edit>
      <btn-delete :info-id="info.id" :no="no"></btn-delete>

      <button
        @click="exportFileLinhMuc()"
        data-toggle="tooltip"
        title=""
        class=""
        data-original-title="Export word"
      >
        <div class="icons8-microsoft-word"></div>
      </button>
    </td>
  </tr>
</template>

<script>
import BtnEdit from './TheBtnEdit'
import BtnDelete from './TheBtnDelete'
import { mapState, mapActions } from 'vuex'
import { MODULE_MODULE_LINH_MUC_EDIT } from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'

export default {
  name: 'TheItem',
  components: {
    BtnEdit,
    BtnDelete,
  },
  props: {
    info: {
      type: Object,
    },
    no: {
      default: 1,
    },
  },
  data() {
    return {}
  },
  computed: {
    ...mapState({
      meta: (state) => state.cfApp.collectionData,
    }),
  },
  methods: {
    ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, ['ACTION_EXPORT_LINH_MUC']),
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    _getTen() {
      return `${this.info.ten_thanh}-${this.info.ten}`
    },
    exportFileLinhMuc() {
      this.ACTION_EXPORT_LINH_MUC({id: this.info.id, name: this.info.ten})
    },
  },
}
</script>

<style scoped>
.icons8-microsoft-word {
  display: inline-block;
  width: 17px;
  height: 17px;
  background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4Igp3aWR0aD0iMjQiIGhlaWdodD0iMjQiCnZpZXdCb3g9IjAgMCAyNCAyNCIKc3R5bGU9IiBmaWxsOiMwMDAwMDA7Ij4gICAgPHBhdGggZD0iTSAxNCAzIEwgMiA1IEwgMiAxOSBMIDE0IDIxIEwgMTQgMTkgTCAyMSAxOSBDIDIxLjU1MiAxOSAyMiAxOC41NTIgMjIgMTggTCAyMiA2IEMgMjIgNS40NDggMjEuNTUyIDUgMjEgNSBMIDE0IDUgTCAxNCAzIHogTSAxMiA1LjM2MTMyODEgTCAxMiAxOC42Mzg2NzIgTCA0IDE3LjMwNjY0MSBMIDQgNi42OTMzNTk0IEwgMTIgNS4zNjEzMjgxIHogTSAxNCA3IEwgMjAgNyBMIDIwIDkgTCAxNCA5IEwgMTQgNyB6IE0gNC41IDguNSBMIDUuNzk4ODI4MSAxNS41IEwgNy4wOTE3OTY5IDE1LjUgTCA3LjkzOTQ1MzEgMTEuNzU3ODEyIEMgNy45ODA0NTMxIDExLjU1MDgxMyA4LjAxMjI5NjkgMTEuMjg5NjA5IDguMDI5Mjk2OSAxMC45NzQ2MDkgTCA4LjA0Njg3NSAxMC45NzQ2MDkgQyA4LjA1NDg3NSAxMS4yNjI2MDkgOC4wNzgxNDA2IDExLjUyMzgxMyA4LjExOTE0MDYgMTEuNzU3ODEyIEwgOC45NDkyMTg4IDE1LjUgTCAxMC4xOTE0MDYgMTUuNSBMIDExLjUgOC41IEwgMTAuMTM0NzY2IDguNSBMIDkuNjgzNTkzOCAxMS43MjI2NTYgQyA5LjY1MDU5MzcgMTEuOTkyNjU2IDkuNjI1MTg3NSAxMi4yNTM4NTkgOS42MTcxODc1IDEyLjUwNTg1OSBMIDkuNjAxNTYyNSAxMi41MDU4NTkgQyA5LjU3NzU2MjUgMTIuMTgxODU5IDkuNTUyNTMxMiAxMS45Mjg4MTIgOS41MTk1MzEyIDExLjc1NzgxMiBMIDguOTY2Nzk2OSA4LjUgTCA3LjIwMTE3MTkgOC41IEwgNi42MDc0MjE5IDExLjc2NzU3OCBDIDYuNTQ5NDIxOSAxMi4wNjU1NzggNi41MTU4MTI1IDEyLjM0NDg5MSA2LjUwNzgxMjUgMTIuNTg3ODkxIEwgNi40ODI0MjE5IDEyLjU4Nzg5MSBDIDYuNDc0NDIxOSAxMi4yNTQ4OTEgNi40NTA5Njg4IDExLjk4MzE1NiA2LjQxNzk2ODggMTEuNzg1MTU2IEwgNS45NTExNzE5IDguNSBMIDQuNSA4LjUgeiBNIDE0IDExIEwgMjAgMTEgTCAyMCAxMyBMIDE0IDEzIEwgMTQgMTEgeiBNIDE0IDE1IEwgMjAgMTUgTCAyMCAxNyBMIDE0IDE3IEwgMTQgMTUgeiI+PC9wYXRoPjwvc3ZnPg==')
    50% 50% no-repeat;
  background-size: 100%;
}
</style>
