<template>
    <div id="content">
                <div class="page-header">
                    <div class="container-fluid">
                      <h1>Nhóm Tin</h1>
                      <breadcrumb></breadcrumb>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-pencil"></i>Hình ảnh tin tức</h3>
                          </div>
                    
                        <div class="panel-body">
                            <div id="elfinder"></div>
                        </div>
                    </div>            
                </div>                   
    </div>                        
</template>

<script>
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        fn_get_base_url,
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
                fullPage: false,
                loading: true
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
