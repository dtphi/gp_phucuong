<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <breadcrumb></breadcrumb>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Users List</h3>
                                <div style="float:right">
                                    <btn-add></btn-add>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <perpage></perpage>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <list-search></list-search>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-striped tbl-custom">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Created from</th>
                                                    <th>Key</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <template v-if="loading">
                                                        <loading-over-lay 
                                                            :active.sync="loading" 
                                                            :is-full-page="fullPage"></loading-over-lay>
                                                    </template>
                                                    <template v-if="_notEmpty">
                                                        <item
                                                            v-for="(item,index) in _userList"
                                                            :no="index"
                                                            :user="item"
                                                            :key="item.id"></item>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <paginate></paginate>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <user-form></user-form>
        <v-dialog></v-dialog>
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import {
        mapState, 
        mapGetters, 
        mapActions
    } from 'vuex';
    import UserForm from 'com@admin/Modal/Users/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Item from './components/TheItem';
    import BtnAdd from './components/TheBtnAdd';
    import Paginate from 'com@admin/Pagination';
    import Perpage from 'com@admin/Pagination/SelectPerpage';
    import ListSearch from 'com@admin/Search';
    import {
        MODULE_USER,
        MODULE_USER_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_USER_LIST,
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'UserList',
        beforeCreate() {
            this.$store.dispatch(MODULE_USER + '/' + ACTION_GET_USER_LIST);
        },
        components: {
            Breadcrumb,
            UserForm,
            Item,
            BtnAdd,
            Perpage,
            ListSearch,
            Paginate
        },
        data() {
            return {
                fullPage: false
            };
        },
        computed: {
            ...mapGetters(['isNotEmptyList']),

            ...mapState(MODULE_USER, [
                'users',
                'loading'
            ]),

            ...mapState(MODULE_USER_MODAL, [
                'updateSuccess'
            ]),

            _userList() {
                return this.users;
            },

            _notEmpty() {
                return this.isNotEmptyList;
            }
        },
        watch: {
            'updateSuccess'( newValue, oldValue ) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        mounted() {
            window.Echo.channel('search-user')
            .listen('.searchAllResults', (e) => {
                this.$store.commit(MODULE_USER + '/' + 'USERS_SET_USER_LIST', e.users.results)
            })
        },
        methods: {
            ...mapActions(['getNo']),
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.$store.dispatch(MODULE_USER_MODAL + '/' + ACTION_RESET_NOTIFICATION_INFO, '');
            }
        }
    };
</script>
