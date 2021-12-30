<template>
  <transition name="modal-tab-general">
    <div class="card-body">
      <div class="form-group row">
        <label for="news_setting" class="col-sm-2 col-form-label">.....</label>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'TabSettingForm',
  props: {
    settingData: {
      type: Object,
    },
  },
}
</script>
