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
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheButtonAdd',
        props: {
            isRedirect: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {};
        },
        methods: {
            ...mapActions(MODULE_INFO_MODAL, [ACTION_SHOW_MODAL]),
            _showModal() {
                if (this.isRedirect) {
                    return this._redirectUrl();
                } else {
                    this.[ACTION_SHOW_MODAL]('add');
                }
            },

            _redirectUrl() {
                return fn_redirect_url('admin/news/add');
            }
        }
    };
</script>
