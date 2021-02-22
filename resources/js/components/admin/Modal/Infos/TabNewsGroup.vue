<template>
    <transition name="modal-tab-general">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Group Selected: </label>
                <div class="col-sm-9">
                    <span>{{_selectedGroup}}</span>
                </div>
            </div>
            <div class="form-group row" style="height:350px;overflow-y: scroll;">
                <div class="treeview-animated mx-4 my-4">
                    <ul class="treeview-animated-list">
                        <tree-item
                            :is-root="rootKey"
                            class="treeview-animated-items"
                            :item="_lists.root"></tree-item>
                    </ul>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import {
        mapState, 
        mapGetters, 
        mapActions
    } from 'vuex';
    import TreeItem from './NewsGroup/TreeItem';
    import {
        MODULE_NEWS_GROUP,
        MODULE_NEWS_GROUP_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST,
    } from 'store@admin/types/action-types';

    export default {
        name: 'TabNewsGroupForm',

        beforeCreate() {
            this.$store.dispatch(MODULE_NEWS_GROUP + '/' + ACTION_GET_NEWS_GROUP_LIST);
        },

        components: {
            TreeItem
        },

        props: {
            groupData: {
                type: Object
            }
        },

        data() {
            return {
                rootKey: 1
            };
        },

        computed: {
            ...mapState(MODULE_NEWS_GROUP,
                [
                    'newsGroups'
                ]),
            ...mapGetters(MODULE_NEWS_GROUP, ['loading']),
            ...mapGetters(MODULE_NEWS_GROUP_MODAL, ['isOpen']),
            _lists() {
                let rootTree = {...this.newsGroups};

                return {
                    root: rootTree
                }
            },
            _selectedGroup() {
                return this.groupData.newsgroup_id ? this.groupData.newsgroupname : 'Not select'
            }
        },

        methods: {},

        setting: {}
    };
</script>
