<template>
    <a
        href="javascript:void(0);"
        data-toggle="tooltip"
        @click="_showConfirm()"
        class="btn btn-default cms-btn"
        :data-original-title="$options.setting.btn_delete_txt">
        <font-awesome-layers size="1x" style="background:MistyRose">
            <font-awesome-icon icon="circle" style="color:Tomato"/>
            <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
        </font-awesome-layers>
    </a>
</template>

<script>
    import {mapActions} from 'vuex';
    import {
        MODULE_USER,
        MODULE_USER_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_USER_DELETE_BY_ID,
        ACTION_DELETE_USER_BY_ID
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonDelete',
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
            ...mapActions(MODULE_USER, [
                ACTION_SET_USER_DELETE_BY_ID,
                ACTION_DELETE_USER_BY_ID
            ]),

            _showConfirm() {
                this.[ACTION_SET_USER_DELETE_BY_ID](this.userId);
                this.$modal.show('dialog', {
                    title: this.$options.setting.modal_title_txt,
                    text: this.$options.setting.content_txt,
                    buttons: [
                        {
                            title: this.$options.setting.btn_delete_cancel_txt,
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                        {
                            title: this.$options.setting.btn_delete_submit_txt,
                            handler: () => {
                                this.[ACTION_DELETE_USER_BY_ID]();
                                this.$modal.hide('dialog')
                            }
                        }
                    ]
                })
            }
        },
        setting: {
            btn_delete_txt: 'Xóa người dùng',
            btn_delete_submit_txt: 'Xóa',
            btn_delete_cancel_txt: 'Hủy',
            modal_title_txt: 'Xóa Người Dùng',
            content_txt: 'Bạn muốn xóa người dùng này ?',
        }
    };
</script>
