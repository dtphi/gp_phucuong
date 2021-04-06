<template>
    <a href="javascript:void(0);" data-toggle="tooltip" 
        @click="_showConfirm()"
        class="btn btn-default cms-btn" 
        data-original-title="Xóa User">
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
        data() {
            return {};
        },
        methods: {
            ...mapActions(MODULE_USER, [
                ACTION_SET_USER_DELETE_BY_ID,
                ACTION_DELETE_USER_BY_ID
            ]),

            _showConfirm() {
                console.log(this);
                this.[ACTION_SET_USER_DELETE_BY_ID](this.userId);
                this.$modal.show('dialog', {
                    title: 'Xóa Người Dùng',
                    text: 'Bạn muốn xóa người dùng ?',
                    buttons: [
                        {
                            title: 'Hủy',
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                        {
                            title: 'Xóa',
                            handler: () => {
                                this.[ACTION_DELETE_USER_BY_ID]();
                                this.$modal.hide('dialog')
                            }
                        }
                    ]
                })
            }
        }
    };
</script>
