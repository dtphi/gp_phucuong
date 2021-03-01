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
                                <h3 class="card-title">File List</h3>
                                <div style="float:right">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                
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
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import {
        mapState, 
        mapGetters, 
        mapActions
    } from 'vuex';
    import Breadcrumb from 'com@admin/Breadcrumb';
    
    import {
        MODULE_USER
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_USER_LIST,
        ACTION_SET_LOADING
    } from 'store@admin/types/action-types';

    export default {
        name: 'FileManagerList',
        beforeCreate() {
            this.$store.dispatch(MODULE_USER + '/' + ACTION_GET_USER_LIST);
        },
        components: {
            Breadcrumb
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

            _userList() {
                return this.users;
            },

            _notEmpty() {
                return this.isNotEmptyList;
            }
        },
        methods: {
            ...mapActions(MODULE_USER, [ACTION_SET_LOADING]),
        }
    };
</script>
