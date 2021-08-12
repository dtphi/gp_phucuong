<template>
    <a href="javascript:void(0);" data-toggle="tooltip"
       @click="_showModal()"
       class="btn btn-default cms-btn"
       data-original-title="Sửa Tin">
        <font-awesome-layers size="1x" style="background:honeydew">
            <font-awesome-icon icon="edit"/>
        </font-awesome-layers>
    </a>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_TINTUC_GIAOPHAN_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL_EDIT
    } from 'store@admin/types/action-types';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheButtonEditGiaoPhanTinTuc',
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
            ...mapActions(MODULE_TINTUC_GIAOPHAN_MODAL, [
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
                return fn_redirect_url(`admin/giao-phan/tin-tucs/edit/${this.infoId}`);
            }
        }
    };
</script>
