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
    <td class="text-left">{{ info.ip }}</td>
    <td class="text-left">{{ info.active }}</td>
    <td class="text-right">
      <btn-edit :info-id="info.id" :href-edit="info.hrefDetail"></btn-edit>
      <btn-delete :info-id="info.id"></btn-delete>
    </td>
  </tr>
</template>

<script>
import { mapState } from "vuex";
import BtnEdit from "./TheBtnEdit";
import BtnDelete from "./TheBtnDelete";

export default {
  name: "TheItem",
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
    return {};
  },
  computed: {
    ...mapState({
      meta: (state) => state.cfApp.collectionData,
    }),
  },
  methods: {
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from);
    },
  },
};
</script>
