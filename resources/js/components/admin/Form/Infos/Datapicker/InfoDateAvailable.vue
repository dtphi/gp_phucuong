<template>
  <div>
    <div class="col-sm-5">
      <label class="control-label">{{groupData.date_available}}</label>
    </div>
    <div class="col-sm-5">
        <date-picker v-model="groupData.date_available" type="datetime"></date-picker>
    </div>
  </div>
</template>

<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    components: { DatePicker },
    props: {
    	groupData: {
          type: Object
      },
    },
    data() {
      return {
      };
    },
  };
</script>
