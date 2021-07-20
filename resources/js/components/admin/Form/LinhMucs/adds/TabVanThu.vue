<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <info-list :lists="groupData.van_thus"></info-list>
      </div>
    </div>
  </div>
</template>

<script>
import InfoList from "./VanThus/InfoList";

export default {
  name: "TabVanThuForm",
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
      van_thus: [],
    };
  },
};
</script>
