<template>
  <div class="modal-header">
    <label class="col-sm-2">Parent name:</label>
      
    <div class="col-sm-10">
      <p>{{parentInfo.newsgroupname}}</p>
    </div>
  </div>
</template>

<script>

export default {
  name: 'TheGroupInfo',
  props: {
    parentInfo: {
      type: Object,
      default: {},
      validator: function(value) {
        var id = (value.id && Number.isInteger(value.id));
        var name = (value.newsgroupname && value.newsgroupname.length);

        return (id && name);
      }
    }
  }
};
</script>
