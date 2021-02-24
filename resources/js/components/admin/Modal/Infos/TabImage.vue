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
    import { EventBus } from '@app/api/utils/event-bus';

    export default {
        name: 'TabImageForm',

        props: {
            groupData: {
                type: Object
            }
        },

        data() {
            return {
                mediaMM : null
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
                EventBus.$emit('on-selected-image', fi);
            }
        },

        setting: {}
    };
</script>
