<template>
	<button 
		type="button" 
		data-toggle="tooltip"
		@click="_showModal()"
    :title="$options.setting.btn_add_txt" class="btn btn-default cms-btn">
          <font-awesome-layers style="background:honeydew">
              <font-awesome-icon size="1x" icon="plus"/>
          </font-awesome-layers>
  </button>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_USER_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonAdd',
        methods: {
            ...mapActions(MODULE_USER_MODAL, [
                ACTION_SHOW_MODAL
            ]),

            _showModal() {
                this[ACTION_SHOW_MODAL]({action: 'add'});
            }
        },
        setting: {
            btn_add_txt: 'Thêm hình ảnh bổ sung',
        }
    };
</script>
