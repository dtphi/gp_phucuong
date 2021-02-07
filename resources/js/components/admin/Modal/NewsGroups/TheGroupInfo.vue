<template>
  <div class="modal-header">
    <label class="col-sm-2">Parent name:</label>
      
    <div class="col-sm-10">
      <p>{{parentInfo.name}}</p>
    </div>
  </div>
</template>

<script>

export default {
  name: 'TheGroupInfo',
  props: {
    parentInfo: Object
  }
};
</script>
