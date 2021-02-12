<template>
    <button type="button" class="btn btn-default mb-3" @click="_showModal()">
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
        name: 'TheButtonAdd',
        data() {
            return {
            };
        },
        methods: {
        	...mapActions(MODULE_USER_MODAL, [ACTION_SHOW_MODAL]),

            _showModal() {
                this.[ACTION_SHOW_MODAL]({action: 'add'});
            }
        }
    };
</script>