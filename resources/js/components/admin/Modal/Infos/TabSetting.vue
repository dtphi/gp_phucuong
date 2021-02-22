<template>
    <transition name="modal-tab-general">
        <div class="card-body">
            <div class="form-group row">
                <label for="news_setting" class="col-sm-2 col-form-label">.....</label>
                <div id="media-manager"></div>
            </div>
        </div>
    </transition>
</template>

<script>
    require ('../../libs/mm/style.css');
    import { MM } from 'com@admin/libs/mm/mm.min';

    export default {
        name: 'TabSettingForm',

        props: {
            settingData: {
                type: Object
            }
        },

        mounted () {
            new MM({
                el: '#media-manager',
                api: {
                    baseUrl: 'http://localhost:8000/api',
                    listUrl: 'list',
                    downloadUrl: 'download',  // optional
                    uploadUrl: 'upload',      // optional
                    deleteUrl: 'delete'       // optional
                }
            });
        },

        methods: {},

        setting: {}
    };
</script>
