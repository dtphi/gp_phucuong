<template>
    <div>
        <span class="mb-1" @click="_showModal()">
          <font-awesome-layers class="fa-1x" style="background:#FFF">
          <font-awesome-icon icon="plus" size="xs"/>
          </font-awesome-layers>
        </span>

        <transition name="action_show" v-if="!isActionShow">
          <span class="mb-1" @click="_showModalEdit()">
            <font-awesome-layers class="fa-1x" style="background:#FFF">
            <font-awesome-icon icon="edit" size="xs"/>
            </font-awesome-layers>
          </span>
        </transition>

        <transition name="action_show" v-if="!isActionShow">
            <span class="mb-1" @click="_showConfirm()">
                <font-awesome-layers class="fa-1x" style="background:#FFF">
                  <font-awesome-icon icon="circle" style="color:Tomato"/>
                  <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-6"/>
                </font-awesome-layers>
            </span>
        </transition>
    </div>
</template>

<script>
    import {
        mapGetters, 
        mapActions
    } from 'vuex';
    import { EventBus } from '@app/api/utils/event-bus';
    import {
        MODULE_NEWS_GROUP,
        MODULE_NEWS_GROUP_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_NEWS_GROUP_DELETE_BY_ID,
        ACTION_DELETE_NEWS_GROUP_BY_ID,
        ACTION_SHOW_MODAL,
        ACTION_SHOW_MODAL_EDIT
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheActionGroup',
        props: {
            isActionShow: 0,
            currentGroup: [Object, Array]
        },
        data: function () {
            return {};
        },
        computed: {
            ...mapGetters(MODULE_NEWS_GROUP_MODAL, [
                'isOpen'
            ]),

            activeStyle() {
                if (this.isOpen) {
                    return this.$options.setting.activeStyle
                }

                return '';
            }
        },
        methods: {
            ...mapActions(MODULE_NEWS_GROUP, [
                ACTION_SET_NEWS_GROUP_DELETE_BY_ID,
                ACTION_DELETE_NEWS_GROUP_BY_ID
            ]),
            ...mapActions(MODULE_NEWS_GROUP_MODAL, [
                ACTION_SHOW_MODAL,
                ACTION_SHOW_MODAL_EDIT
            ]),

            _showModal() {
                this.[ACTION_SHOW_MODAL]({
                    action: 'add',
                    groupId: this.currentGroup.id,
                    itemRoot: this.isActionShow
                });
            },

            _showModalEdit() {
                this.[ACTION_SHOW_MODAL_EDIT]({
                    action: 'edit',
                    groupId: this.currentGroup.id
                });
            },

            _showConfirm() {
                this.[ACTION_SET_NEWS_GROUP_DELETE_BY_ID](this.currentGroup.id);
                this.$modal.show('dialog', {
                    title: 'Delete Confirm',
                    text: 'Are you sure delete news group?',
                    buttons: [
                        {
                            title: 'Cancel',
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                        {
                            title: 'Delete',
                            handler: () => {
                                this.[ACTION_DELETE_NEWS_GROUP_BY_ID]();
                                this.$modal.hide('dialog')
                            }
                        }
                    ]
                })
            }
        },
        mounted() {
            const _self = this;

            if (Object.keys(_self.currentGroup).length === 0) {
                EventBus.$on('on-add-group', () => {
                    _self._showModal();
                });
            }
        },
        setting: {
            activeStyle: 'background-color:#93d3a2'
        }
    };
</script>

