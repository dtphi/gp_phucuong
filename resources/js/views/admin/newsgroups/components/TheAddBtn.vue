<template>
    <span class="mb-1" @click="_showModal()">
      <font-awesome-layers class="fa-1x" style="background:#FFF">
      <font-awesome-icon icon="plus" size="xs"/>
      </font-awesome-layers>
    </span>
</template>

<script>
    import {
        mapGetters, 
        mapActions
    } from 'vuex';
    import { EventBus } from '@app/api/utils/event-bus';
    import {
        MODULE_NEWS_GROUP_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheAddBtnGroup',
        props: {
            isActionShow: 0,
            currentGroup: [Object, Array]
        },
        methods: {
            ...mapActions(MODULE_NEWS_GROUP_MODAL, [
                ACTION_SHOW_MODAL
            ]),

            _showModal() {
                this.[ACTION_SHOW_MODAL]({
                    action: 'add',
                    groupId: this.currentGroup.id,
                    itemRoot: this.isActionShow
                });
            }
        },
        mounted() {
            const _self = this;

            if (Object.keys(_self.currentGroup).length === 0) {
                EventBus.$on('on-add-group', () => {
                    _self._showModal();
                });
            }
        }
    };
</script>

