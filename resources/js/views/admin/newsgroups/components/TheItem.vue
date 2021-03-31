<template>
    <div>
        <a class="treeview-animated-items-header"
           v-on:mouseover.prevent="_showAction"
           v-on:mouseleave.prevent="_hideAction">
            <font-awesome-icon icon="folder" v-if="isItemRoot"/>
            <font-awesome-icon icon="plus" size="xs" v-if="isFolder && !isItemRoot" />
            <span>{{ group.newsgroupname }}</span>
            <btn-group-action
                :is-action-show="isItemRoot"
                :current-group="group"
                v-show="active"
                class="float-sm-right center"
                style="margin-top:0px"></btn-group-action>
        </a>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {
        MODULE_NEWS_GROUP_MODAL
    } from 'store@admin/types/module-types';
    import BtnGroupAction from './TheActionGroup';

    export default {
        name: 'TheItem',
        components: {BtnGroupAction},
        props: {
            isItemRoot: 0,
            group: [Object, Array],
            isFolder: Number
        },
        data: function () {
            return {
                active: false
            };
        },
        computed: {
            ...mapGetters(MODULE_NEWS_GROUP_MODAL, [
                'isOpen'
            ]),

            activeStyle: (app) => {
                if (app.isOpen && app.active) {
                    return app.$options.setting.activeStyle
                }

                return '';
            }
        },
        methods: {
            _showAction() {
                this.active = true;
            },

            _hideAction() {
                this.active = false;
            }
        },
        setting: {
            activeStyle: 'background-color:#93d3a2'
        }
    };
</script>
