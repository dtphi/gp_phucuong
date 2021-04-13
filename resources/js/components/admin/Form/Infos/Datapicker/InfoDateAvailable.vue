<template>
  <div>
    <date-picker v-model="groupData.date_available" type="datetime"></date-picker>
  </div>
</template>

<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';
	 import {
	      mapState, 
	      mapGetters, 
	      mapActions
	  } from 'vuex';
	  import {
	      MODULE_NEWS_CATEGORY_ADD
	  } from 'store@admin/types/module-types';
	  import {
	      ACTION_GET_NEWS_GROUP_LIST,
	  } from 'store@admin/types/action-types';

  export default {
    components: { DatePicker },
    props: {
    	groupData: {
                type: Object
            },
    	dateAvailable: {
    		default: null
    	}
    },
    data() {
      return {
        time2: null,
      };
    },
  };
</script>
