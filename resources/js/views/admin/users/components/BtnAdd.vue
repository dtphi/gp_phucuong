<template>
    <button type="button" class="btn btn-default mb-3" @click="showModal('add')">
    	<font-awesome-icon icon="plus"  size="xs" />
    </button>
</template>

<script>
    import { mapActions } from 'vuex';
    import {
      MODULE_USER_MODAL
    } from 'store@admin/types/module-types';
    import {
      ACTION_SHOW_MODAL
    } from 'store@admin/types/action-types';

    export default {
        name: 'ButtonAdd',
        data() {
            return {
            };
        },
        methods: {
        	...mapActions(MODULE_USER_MODAL, [ACTION_SHOW_MODAL]),
        }
    };
</script>