<template>
	<button type="button" 
        data-toggle="tooltip" title="" 
        class="btn btn-default cms-btn" 
        @click="_showConfirm()" 
        data-original-title="Delete">
        <font-awesome-layers size="1x" style="background:MistyRose">
            <font-awesome-icon icon="circle" style="color:Tomato"/>
            <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
        </font-awesome-layers>
    </button>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import {
        MODULE_MODULE_GROUP_ALBUMS,
    } from 'store@admin/types/module-types';
    import {
        ACTION_DELETE_INFO_BY_ID
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheButtonDelete',
        props: {
            infoId: {
                type: Number,
                default: 0,
                validator: function (value) {
                    return (value && Number.isInteger(value))
                }
            },
            no: {
              type: Number,
            },
        },
        computed: {
          ...mapGetters(MODULE_MODULE_GROUP_ALBUMS, ["infos"]),
        },
        methods: {
            ...mapActions(MODULE_MODULE_GROUP_ALBUMS, [         
                ACTION_DELETE_INFO_BY_ID
            ]),

            _delete(){
                this[ACTION_DELETE_INFO_BY_ID](this.infoId); 
            },
            _showConfirm() {
                const _self = this;
                this.$modal.show('dialog', {
                    title: 'Xóa Group Albums',
                    text: 'Bạn muốn xóa group albums ?',
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
                                this.$delete(this.infos, this.no);
                                this._delete();
                                this.$modal.hide('dialog')
                            }
                        }
                    ]
                })
            }
        }
    };
</script>
