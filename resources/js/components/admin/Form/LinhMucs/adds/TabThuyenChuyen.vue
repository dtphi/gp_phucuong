<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <info-list :lists="groupData.thuyen_chuyens"></info-list>
      </div>
    </div>
  </div>
</template>

<script>
import InfoList from './ThuyenChuyens/InfoList'

export default {
  name: 'TabThuyenChuyenForm',
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
      thuyen_chuyens: [],
    }
  },
}
</script>
