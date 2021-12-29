<template>
    <div class="tab-content">
        <div class="form-group">
            <div class="col-sm-12">
                <info-list v-if="giaoXus.length" :lists="giaoXus"></info-list>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, } from 'vuex'
import {
  MODULE_MODULE_GIAO_PHAN_EDIT,
} from 'store@admin/types/module-types'
import InfoList from './HatXuDiemGiaoPhans/InfoList'

export default {
  name: 'TabHatXuDiemForm',
  components: {
    InfoList,
  },
  props: {
    groupData: {
      type: Object,
    },
  },
  computed: {
    ...mapGetters(MODULE_MODULE_GIAO_PHAN_EDIT, [
      'giaoXus'
    ]),
  },
  data() {
    return {
      giao_phan_hat_xu_diems: [],
    }
  },
}
</script>
