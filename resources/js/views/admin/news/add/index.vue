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
                                <h3 class="card-title">Add News</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <info-add-form></info-add-form>
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
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';

    import InfoAddForm from 'com@admin/Form/Infos/AddForm';
    import Breadcrumb from 'com@admin/Breadcrumb';

    export default {
        name: 'InformationAdd',
        components: {
            Breadcrumb,
            InfoAddForm
        }
    };
</script>
