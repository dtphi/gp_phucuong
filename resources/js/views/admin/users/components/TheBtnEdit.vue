<template>
    <a href="javascript:void(0);" data-toggle="tooltip" 
        @click="_showModal()"
        class="btn btn-default cms-btn" 
        data-original-title="Sửa User">
        <font-awesome-layers style="background:honeydew">
            <font-awesome-icon size="1x" icon="edit"/>
        </font-awesome-layers>
    </a>
</template>

<script>
    import {mapActions} from 'vuex';
    import {
        MODULE_USER_EDIT_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL
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
                ACTION_SHOW_MODAL
            ]),

            _showModal() {
                this.[ACTION_SHOW_MODAL](this.userId)
            }
        }
    };
</script>
