<template>
    <button type="button" class="btn btn-default mb-3" @click="showModal('add')">
    	<font-awesome-icon icon="plus"  size="xs" />
    </button>
</template>

<script>
    import { mapActions } from 'vuex';
    import {
      MODULE_USER_MODAL
    } from 'store@admin/module-types';

    export default {
        name: 'ButtonAdd',
        data() {
            return {
            };
        },
        methods: {
        	...mapActions(MODULE_USER_MODAL, ['showModal']),
        }
    };
</script>