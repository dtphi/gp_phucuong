<template>
    <div>
        <div id="media-info-manager_"></div>
        <input type="hidden" class="form-control" id="file-media-info-input" disabled>
    </div>
</template>

<script>
    require('@app/tools/mm/dist/style.css');
    import {MM} from '@app/tools/mm/dist/mm.min';
    import {EventBus} from '@app/api/utils/event-bus';

    export default {
        name: 'TheMediaManage',
        props: {
            selectedImage: {
                type: Function,
                default: function(fi) {
                    if (typeof fi === "object") {
                        if (fi.hasOwnProperty('selected') && fi.selected) {
                            if (fi.selected.hasOwnProperty('path')) {
                                EventBus.$emit('select-info-media-img', {
                                    filePath: fi.selected.path
                                });
                            }
                        }
                    }
                }
            }
        },
        data() {
            return {
                mediaMM: null
            }
        },  
        mounted() {
            const self = this;

            this.mediaMM = new MM({
                el: '#media-info-manager_',
                api: {
                    baseUrl: window.origin + '/api/mmedia',
                    listUrl: 'list',
                    downloadUrl: 'download', 
                    uploadUrl: 'upload',      
                    deleteUrl: 'delete' 
                },
                input: {
                    el: '#file-media-info-input',
                    multiple: false
                },
                onSelect: function (event) {
                    self._changeImage(event);
                }
            });
        },
        methods: {
            _changeImage(fi) {
                this.selectedImage(fi);
            },
        },
        setting: {
            image_title: 'Banner',
            image_url_title: 'Url hình'
        }
    };
</script>
