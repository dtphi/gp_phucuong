<template>
    <button type="button" class="btn btn-default mb-3" @click="showAddModal()">
    	<font-awesome-icon icon="plus"  size="xs" />
    </button>
</template>

<script>
    import { mapActions } from 'vuex';
    import {
      MODULE_INFO_MODAL
    } from 'store@admin/types/module-types';
    import {
      ACTION_SHOW_MODAL
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonAdd',
        data() {
            return {
            };
        },
        methods: {
        	...mapActions(MODULE_INFO_MODAL, [ACTION_SHOW_MODAL]),
        	showAddModal() {
        		console.log('show modal')
        		this.[ACTION_SHOW_MODAL]('add');
        	}
        }
    };
</script>