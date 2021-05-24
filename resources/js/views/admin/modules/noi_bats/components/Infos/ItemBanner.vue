<template>
    <div>
        <div class="form-group">
            <label
                class="col-sm-2 control-label"
                for="input-parent-category-name">
                    <span data-toggle="tooltip"
                        data-original-title="(Tự động hoàn toàn)">Key</span>
            </label>
            <div class="col-sm-10">
                <input class="form-control" v-model="settingBanner.key" type="text" disabled/>
            </div>
        
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <div id="media-info-manager"></div>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left">{{$options.setting.image_main_txt}}</td>
                            <td>{{$options.setting.image_main_path_txt}}</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">
                                <div class="file animated fadeIn" style="height: 61px">
                                    <div class="file-preview">
                                        <img :src="_getImgUrl()" class="thumb"/>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="file-input" disabled>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    require('@app/tools/mm/dist/style.css');
    import {MM} from '@app/tools/mm/dist/mm.min';
    import {EventBus} from '@app/api/utils/event-bus';
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_MODULE_NOI_BAT,
        MODULE_INFO_EDIT
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_DROPDOWN_CATEGORY_LIST,
        ACTION_ADD_INFO_TO_CATEGORY_LIST,
        ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA
    } from 'store@admin/types/action-types';
    import lodash from 'lodash';
    import InfoList from './InfoList';

    export default {
        name: 'TheItemBanner',
        components: {
            InfoList
        },
        data() {
            return {
                mediaMM: null
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'settingBanner',
            ]),
        },
        mounted() {
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
                onSelect: function (event) {
                    self._changeImage(event);
                }
            });
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                ACTION_MODULE_UPDATE_RESET_SETTING_CATEGORY_VALUE_DATA
            ]),
            ...mapActions(MODULE_NEWS_CATEGORY, [
                ACTION_GET_DROPDOWN_CATEGORY_LIST
            ]),
            ...mapActions(MODULE_INFO_EDIT, [
                ACTION_ADD_INFO_TO_CATEGORY_LIST
            ]),

            _changeImage(fi) {
                if (typeof fi === "object") {
                    if (fi.hasOwnProperty('selected')) {
                        EventBus.$emit('on-selected-image', fi);
                    }
                }
            },
            _getImgUrl() {
               return fn_get_base_url_image();
            },
        },
        setting: {
            paren_category_txt: 'Danh mục hiển thị thông báo'
        }
    };
</script>
