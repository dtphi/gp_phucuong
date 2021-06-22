<template>
	<button 
		type="button" 
		data-toggle="tooltip"
		@click="_addInfo()"
        title="Thêm công đoàn tu sĩ giáo phận" class="btn btn-default cms-btn">
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
        MODULE_MODULE_GIAO_PHAN_EDIT
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheButtonAdd',
        props: {
            giaoHat: {
                default: null
            },
            moduleKey: {
                default: ''
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_GIAO_PHAN_EDIT, [
                'addHatCongDoanTuSiGiaoPhan'
            ]),

            _addInfo() {
                this.addHatCongDoanTuSiGiaoPhan({
                    action: 'addHatCongDoanTuSiGiaoPhan',
                    giaoHat: this.giaoHat
                });
            }
        },
    };
</script>
