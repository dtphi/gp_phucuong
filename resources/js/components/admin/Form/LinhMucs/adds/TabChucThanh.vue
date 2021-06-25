<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <info-list :lists="groupData.chuc_thanhs"></info-list>
      </div>
    </div>
  </div>
</template>

<script>
import InfoList from "./ChucThanhs/InfoList";

export default {
  name: "TabChucThanhForm",
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
      chuc_thanhs: [],
    };
  },
};
</script>
