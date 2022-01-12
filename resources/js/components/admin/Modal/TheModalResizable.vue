<template>
  <modal
    :name="modalName"
    :min-width="400"
    :min-height="200"
    :resizable="true"
    :clickToClose="false"
    :width="800"
    :height="500"
  >
    <div class="panel panel-default" style="height: 100%; overflow: auto">
      <div class="panel-heading cms-modal-heading">
        <h3 class="panel-title"><i :class="icon"></i>{{ title }}</h3>
      </div>
      <div class="panel-body">
        <form class="form-horizontal cms-modal-form">
          <slot name="cms_modal_form_group"></slot>
        </form>
        <div class="cms-modal-footer-btn">
          <div class="text-center cms-modal-group-btn">
            <slot name="cms_modal_btn_group"></slot>
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  name: 'TheCmsModalResizable',
  props: {
    icon: {
      default: 'fa fa-plus',
    },
    title: {
      default: 'Tiêu Để',
    },
    modalName: {
      default: 'modal-resizable',
    },
  },
}
</script>

<style scoped lang="scss">
.cms-modal-heading {
  color: #eeeeeee8;
  position: absolute;
  width: 100%;
  border-color: #784545;
  background: #2e2222b3;
  z-index: 999999;
}
.cms-modal-form {
  padding: 25px;
}
.cms-modal-footer-btn {
  position: absolute;
  right: 0px;
  bottom: 0px;
  width: 100%;
  background-color: #0e212a;

  .cms-modal-group-btn {
    padding: 10px;
  }
}
</style>