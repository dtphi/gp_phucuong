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
                                <h3 class="card-title">News List</h3>
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
                                            <table
                                                class="table table-bordered table-striped tbl-custom dataTable no-footer dtr-inline"
                                                role="grid" aria-describedby="example1_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="No: activate to sort column descending">No
                                                    </th>
                                                    <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending">Name
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Description: activate to sort column ascending">
                                                        Description
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Created by: activate to sort column ascending">
                                                        Created by
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Key: activate to sort column ascending">Key
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <template v-if="loading">
                                                        <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
                                                    </template>
                                                    <template v-if="_notEmpty">
                                                        <item v-for="(item,index) in _infoList"
                                                          :info="item"
                                                          :no="index"
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

        <InfoAddForm/>

        <v-dialog/>
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import {
        mapState, 
        mapGetters, 
        mapActions
    } from 'vuex';
    import Item from './components/TheItem';

    import InfoAddForm from 'com@admin/Modal/Infos/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import Perpage from 'com@admin/Pagination/SelectPerpage';
    import ListSearch from 'com@admin/Search';
    import Paginate from 'com@admin/Pagination';
    import BtnAdd from './components/TheBtnAdd';
    import {
        MODULE_INFO,
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST,
    } from 'store@admin/types/action-types';

    export default {
        name: 'InformationList',
        components: {
            Breadcrumb,
            BtnAdd,
            Perpage,
            ListSearch,
            InfoAddForm,
            Item,
            Paginate
        },

        beforeCreate() {
            this.$store.dispatch(MODULE_INFO + '/' + ACTION_GET_INFO_LIST);
        },

        data() {
            return {
                fullPage: false
            }
        },

        computed: {
            ...mapGetters(['isNotEmptyList']),
            ...mapState(MODULE_INFO, [
                'infos',
                'loading'
            ]),

            _infoList() {
                return this.infos;
            },

            _notEmpty() {
                return this.isNotEmptyList;
            }
        }
    };
</script>
