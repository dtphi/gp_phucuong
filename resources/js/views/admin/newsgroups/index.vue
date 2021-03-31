<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <breadcrumb></breadcrumb>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <div class="card user-lst">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{$options.setting.title}}
                                </h3>
                                <div style="float:right">
                                    <a href="javascript:void(0);">
                                        <font-awesome-layers size="xs" @click="_showAddModal()" style="background:honeydew">
                                            <font-awesome-icon icon="plus" size="xs"/>
                                        </font-awesome-layers>
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <template v-if="loading">
                                    <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
                                </template>
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
                    </section>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <modal-add-form></modal-add-form>
        <modal-edit-form></modal-edit-form>

        <v-dialog></v-dialog>
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import TreeItem from './components/TheTreeItem';
    import ModalAddForm from 'com@admin/Modal/NewsGroups/AddForm';
    import ModalEditForm from 'com@admin/Modal/NewsGroups/EditForm';
    import { EventBus } from '@app/api/utils/event-bus';
    import {
        MODULE_NEWS_GROUP,
        MODULE_NEWS_GROUP_MODAL,
        MODULE_NEWS_GROUP_EDIT_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'NewsGroupsList',
        components: {
            Breadcrumb, 
            TreeItem, 
            ModalAddForm,
            ModalEditForm
        },
        beforeCreate() {
            this.$store.dispatch(MODULE_NEWS_GROUP + '/' + ACTION_GET_NEWS_GROUP_LIST);
        },
        data() {
            return {
                rootKey: 1,
                fullPage: false
            };
        },
        computed: {
            ...mapState(MODULE_NEWS_GROUP,
            [
                'newsGroups',
                'loading'
            ]),
            ...mapState(MODULE_NEWS_GROUP_MODAL, [
                'insertSuccess'
            ]),
            ...mapState(MODULE_NEWS_GROUP_EDIT_MODAL, [
                'updateSuccess'
            ]),
            _lists() {
                let rootTree = {...this.newsGroups};

                return {
                    root: rootTree
                }
            }
        },
        watch: {
            'insertSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            },
            'updateSuccess'( newValue, oldValue ) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        methods: {
            _showAddModal() {
                EventBus.$emit('on-add-group', true)
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.$store.dispatch(MODULE_NEWS_GROUP_MODAL + '/' + ACTION_RESET_NOTIFICATION_INFO, '');
            }
        },
        setting: {
            title: 'News Groups List'
        }
    };
</script>

<style lang="css" type="text/css">
   @import "./custom-styles.css"; 
</style>