<template>
  <div>
    <div class="col-sm-5">
      <label class="control-label">{{ groupData.date_available }}</label>
    </div>
    <div class="col-sm-5">
      <cms-date-picker
        value-type="format"
        format="YYYY-MM-DD HH:mm:ss"
        v-model="groupData.date_available"
        type="datetime"
      ></cms-date-picker>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    groupData: {
      type: Object,
    },
  },
}
</script>
