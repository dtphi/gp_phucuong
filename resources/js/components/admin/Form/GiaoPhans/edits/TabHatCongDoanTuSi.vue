<template>
    <div class="tab-content">
        <div class="form-group">
            <div class="col-sm-12">
                <info-list :lists="groupData.giao_phan_hats"></info-list>
            </div>
        </div>
    </div>
</template>

<script>
import InfoList from './HatCongDoanTuSiGiaoPhans/InfoList'

export default {
  name: 'TabHatCongDoanTSGiaoPhan',
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
      giao_phan_hat_congdoantusis: [],
    }
  },
}
</script>
