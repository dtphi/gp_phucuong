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
        MODULE_INFO_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL_EDIT
    } from 'store@admin/types/action-types';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheButtonEdit',
        props: {
            isRedirect: {
                type: Boolean,
                default: true
            },
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
                if (this.isRedirect) {
                    this._redirectUrl();
                } else {
                    this.[ACTION_SHOW_MODAL_EDIT](this.infoId);
                }
            },

            _redirectUrl() {
                return fn_redirect_url(`admin/news/edit/${this.infoId}`);
            }
        }
    };
</script>
