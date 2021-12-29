<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <info-list :lists="groupData.giao_phan_dongs"></info-list>
      </div>
    </div>
  </div>
</template>

<script>
import InfoList from './DongGiaoPhans/InfoList'

export default {
  name: 'TabDongGiaoPhan',
  components: {
    InfoList,
  },
  props: {
    groupData: {
      type: Object,
    },
  },
  data() {
    return {
      giao_phan_dongs: [],
    }
  },
}
</script>
