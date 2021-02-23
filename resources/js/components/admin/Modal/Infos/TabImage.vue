<template>
    <transition name="modal-tab-image">
        <div class="card-body">
            <div class="form-group row">
            		<div class="col-sm-12">
            					<div id="media-info-manager"></div>
            		</div>
            		<div class="col-sm-12">
            					<input type="text" id="file-input">
            		</div>
            </div>
        </div>
    </transition>
</template>

<script>
    require ('../../libs/mm/style.css');
    import { MM } from 'com@admin/libs/mm/mm.min';

    export default {
        name: 'TabImageForm',

        props: {
            settingData: {
                type: Object
            }
        },

        mounted () {
            new MM({
                el: '#media-info-manager',
                api: {
                    baseUrl: 'http://localhost:8000/api/mmedia',
                    listUrl: 'list',
                    downloadUrl: 'download',  // optional
                    uploadUrl: 'upload',      // optional
                    deleteUrl: 'delete'       // optional
                },
                input: {
						        el: '#file-input',
						        multiple: false
						    }
            });
        },

        methods: {},

        setting: {}
    };
</script>
