<template>
    <form class="form-horizontal">
        <loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>
        <ul class="nav nav-tabs">
            <li class="active">
                <a
                    href="#tab-chuc-thanh"
                    data-toggle="tab">{{$options.setting.tab_chuc_thanh_title}}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-chuc-thanh">
                <tab-chuc-thanh
                    role="tabpanel"
                    class="tab-pane active"
                    :group-data="info"></tab-chuc-thanh>
            </div>
        </div>
    </form>
</template>

<script>
    import {EventBus} from '@app/api/utils/event-bus';
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_LINH_MUC_EDIT,
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_LOADING,
        ACTION_INSERT_INFO,
        ACTION_SET_IMAGE,
        ACTION_INSERT_INFO_BACK
    } from 'store@admin/types/action-types';
    import TabChucThanh from './edits/TabChucThanh';

    export default {
        name: 'FormEdit',
        components: {
            TabChucThanh
        },
        data() {
            return {
                fullPage: false,
                file: null
            };
        },
        computed: {
            ...mapState(MODULE_MODULE_LINH_MUC_EDIT, {
                loading: state => state.loading
            }),
            ...mapGetters(MODULE_MODULE_LINH_MUC_EDIT, [
                'info',
            ])
        },
        mounted() {
            const _self = this;
            EventBus.$on('on-selected-image', (imgItem) => {
                _self.$data.file = imgItem;
                _self._selectMainImg(imgItem);
            });
        },
        methods: {
            ...mapActions(MODULE_MODULE_LINH_MUC_EDIT, [
                ACTION_SET_LOADING,
                ACTION_INSERT_INFO,
                ACTION_INSERT_INFO_BACK,
                ACTION_SET_IMAGE
            ]),
            _submitInfo() {
                this.[ACTION_INSERT_INFO](this.info);
            },
            _submitInfoBack() {
                this.[ACTION_INSERT_INFO_BACK](this.info);
            },
            _selectMainImg(file) {
                const image = {
                    basename: "",
                    dirname: "",
                    extension: "",
                    filename: "",
                    path: "",
                    size: 0,
                    thumb: "",
                    timestamp: '',
                    type: ""
                };
                if (typeof file === "object") {
                    let selected = image;

                    if (file.hasOwnProperty('selected') && file.selected) {
                        selected = file.selected;
                    }

                    this.[ACTION_SET_IMAGE](selected);
                }
            }
        },
        setting: {
            tab_general_title: 'Tổng quan',
            tab_bang_cap_title: 'Bằng Cấp',
            tab_chuc_thanh_title: 'Chức Thánh',
            tab_thuyen_chuyen_title: 'Thuyên Chuyển',
            tab_van_thu_title: 'Văn Thư',
            tab_special_info_title: 'Slide tin tức tiêu điểm',
            error_msg_system: 'Lỗi hệ thống !',
            isForm: 'edit'
        }
    };
</script>
