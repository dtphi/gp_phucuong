<template>
  <modal name="confirm-modal"
         :width="300"
         :height="300"
         :adaptive="true">
    Hello, Properties!
  </modal>
</template>
<script>
export default {
  name: 'ConfirmModal',
  methods: {
      show () {
          this.$modal.show('confirm-modal');
      },
      hide () {
          this.$modal.hide('confirm-modal');
      }
  },
  mount () {
      this.show()
  }
}
</script>