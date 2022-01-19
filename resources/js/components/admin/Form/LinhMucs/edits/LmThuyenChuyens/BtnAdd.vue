<template>
  <button
    type="button"
    data-toggle="tooltip"
    @click.prevent="_showModal()"
    title="Thêm bổ nhiệm"
    class="btn btn-default cms-btn"
  >
    <i class="fa fa-plus" />
  </button>
</template>

<script>

export default {
  name: 'TheButtonAdd',
  props: {
    moduleKey: {
      default: '',
    },
  },
  methods: {
    _showModal() {
      this.$emit('show-modal-add')
    },
  },
}
</script>
