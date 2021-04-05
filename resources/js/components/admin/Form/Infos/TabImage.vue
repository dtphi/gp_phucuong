<template>
    <div class="tab-content">
        <div class="form-group row">
        		<div class="col-sm-12">
        			<div id="media-info-manager"></div>
        		</div>
        		<div class="col-sm-12">
        			<input type="text" id="file-input" disabled>
        		</div>
        </div>
        <div class="form-group row" v-if="_isShowImgThumb">
                <div class="col-sm-3">Picture :</div>
                <div class="col-sm-9">
                    <div class="file animated fadeIn">
                        <div class="file-preview">
                            <img :src="_getImgUrl()" class="thumb" />
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    require ('@app/tools/mm/dist/style.css');
    import { MM } from '@app/tools/mm/dist/mm.min';
    import { EventBus } from '@app/api/utils/event-bus';
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TabImageForm',

        props: {
            groupData: {
                type: Object
            },
            configForm: {}
        },

        data() {
            return {
                mediaMM : null
            }
        },

        computed: {
            _isShowImgThumb() {
                return this._isEditForm();
            }
        },

        mounted () {
            const self = this;

            this.mediaMM = new MM({
                el: '#media-info-manager',
                api: {
                    baseUrl: window.origin + '/api/mmedia',
                    listUrl: 'list',
                    downloadUrl: 'download',  // optional
                    uploadUrl: 'upload',      // optional
                    deleteUrl: 'delete'       // optional
                },
                input: {
			        el: '#file-input',
			        multiple: false
				},
                onSelect : function(event) {
                    self._changeImage(event);
                }
            });
            console.log(this)
        },

        methods: {
            _changeImage(fi) {
                EventBus.$emit('on-selected-image', fi)
            },
            _getImgUrl() {
                return fn_get_base_url_image(this.groupData.picture);
            },
            _isEditForm() {
                return (Object.keys(this.groupData).length) ? (this.groupData.id ? true: false): false;
            }
        },

        setting: {}
    };
</script>
