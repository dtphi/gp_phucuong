<template>
    <button type="button" class="btn btn-default mb-3" @click="_showModal()">
        <font-awesome-icon icon="edit" size="xs"/>
    </button>
</template>

<script>
    import {mapActions} from 'vuex';
    import {
        MODULE_INFO_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL_EDIT
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonEdit',
        props: {
            infoId: {
                type: Number,
                default: 0,
                validator: function (value) {
                    return (value && Number.isInteger(value))
                }
            }
        },
        data() {
            return {};
        },
        methods: {
            ...mapActions(MODULE_INFO_MODAL, [
                ACTION_SHOW_MODAL_EDIT
            ]),
            _showModal() {
                this.[ACTION_SHOW_MODAL_EDIT](this.infoId);
            }
        }
    };
</script>
