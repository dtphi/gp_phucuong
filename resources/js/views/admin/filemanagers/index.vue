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
                                <div id="elfinder"></div>
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
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        fn_get_news_file_connector_url,
        fn_get_news_file_sound_url
    } from '@app/api/utils/fn-helper';

    require ('@app/tools/barryvdh/jqueryui-1.10.4/jquery-ui.css');
    require ('@app/tools/barryvdh/css/elfinder.min.css');
    require ('@app/tools/barryvdh/css/theme.css');

    export default {
        name: 'FileManagerList',
        components: {
            Breadcrumb
        },
        data() {
            return {
                fullPage: false
            };
        },
        mounted () {
            const self = this;

            $().ready(function() {
                $('#elfinder').elfinder({
                    lang: 'vi',
                    customData: { 
                        _token: ''
                    },
                    url : fn_get_news_file_connector_url(),
                    soundPath: fn_get_news_file_sound_url()
                });
            });
        }
    };
</script>
