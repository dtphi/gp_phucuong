<template>
    <button type="button" class="btn btn-default mb-3">
    	<font-awesome-layers class="fa-1x" style="background:MistyRose">
			  <font-awesome-icon icon="circle" style="color:Tomato" />
			  <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-6" />
			</font-awesome-layers>
    </button>
</template>

<script>
    import { mapActions } from 'vuex';
    import {
      MODULE_USER_MODAL
    } from 'store@admin/module-types';

    export default {
        name: 'ButtonDelete',
        props: {
            userId: { type: Number, dafault: 0 },
            iconName: { type: String, default: '' },
            className: { type: String, default: '' }
        },
        data() {
            return {
            };
        },
        methods: {
            ...mapActions(MODULE_USER_MODAL, [
                'showModalEdit'
            ]),
        }
    };
</script>