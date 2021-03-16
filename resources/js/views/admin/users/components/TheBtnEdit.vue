<template>
    <a href="javascript:void(0);">
        <font-awesome-layers size="xs" @click="_showModal()" style="background:honeydew">
            <font-awesome-icon icon="edit"/>
        </font-awesome-layers>
    </a>
</template>

<script>
    import {mapActions} from 'vuex';
    import {
        MODULE_USER_EDIT_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL_EDIT
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonEdit',
        props: {
            userId: {
                type: Number,
                default: 0,
                validator: function (value) {
                    return (value && Number.isInteger(value))
                }
            }
        },
        methods: {
            ...mapActions(MODULE_USER_EDIT_MODAL, [
                ACTION_SHOW_MODAL_EDIT
            ]),

            _showModal() {
                this.[ACTION_SHOW_MODAL_EDIT](this.userId)
            }
        }
    };
</script>
