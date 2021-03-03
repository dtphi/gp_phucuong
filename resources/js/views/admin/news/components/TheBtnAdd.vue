<template>
    <a href="javascript:void(0);">
        <font-awesome-layers size="xs" @click="_showModal()" style="background:honeydew">
            <font-awesome-icon icon="plus" size="xs"/>
        </font-awesome-layers>
    </a>
</template>

<script>
    import {mapActions} from 'vuex';
    import {
        MODULE_INFO_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonAdd',
        data() {
            return {};
        },
        methods: {
            ...mapActions(MODULE_INFO_MODAL, [ACTION_SHOW_MODAL]),
            _showModal() {
                this.[ACTION_SHOW_MODAL]('add');
            }
        }
    };
</script>
