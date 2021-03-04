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
                                <h3 class="card-title">Edit News</h3>
                                <span class="text-green" style="float:right">{{updateSuccess}}</span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                 <info-edit-form></info-edit-form>
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

    import InfoEditForm from 'com@admin/Form/Infos/EditForm';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        MODULE_INFO_EDIT,
    } from 'store@admin/types/module-types';
    import {
        ACTION_SHOW_MODAL_EDIT,
    } from 'store@admin/types/action-types';

    export default {
        name: 'InformationEdit',
        components: {
            Breadcrumb,
            InfoEditForm,
        },

        beforeCreate() {
        	const infoId = parseInt(this.$route.params.infoId);
            this.$store.dispatch(MODULE_INFO_EDIT + '/' + ACTION_SHOW_MODAL_EDIT, infoId);
        },

        data() {
            return {
                fullPage: false
            }
        },

        computed: {
            ...mapState(MODULE_INFO_EDIT, [
                'loading',
                'updateSuccess'
            ])
        }
    };
</script>
