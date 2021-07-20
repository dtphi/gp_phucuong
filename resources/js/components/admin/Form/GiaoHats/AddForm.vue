<template>
    <form class="form-horizontal">
        <!--<loading-over-lay
            :active.sync="loading"
            :is-full-page="fullPage"></loading-over-lay>-->
        <ul class="nav nav-tabs">
            <li class="active">
                <a
                    href="#tab-giao-hat"
                    data-toggle="tab">Hạt</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-giao-hat">
                <tab-giao-hat
                    role="tabpanel"
                    class="tab-pane active"
                    :group-data="info"></tab-giao-hat>
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
        MODULE_MODULE_GIAO_PHAN_ADD,
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_LOADING,
        ACTION_INSERT_INFO,
        ACTION_SET_IMAGE,
        ACTION_INSERT_INFO_BACK
    } from 'store@admin/types/action-types';
    import TabGiaoHat from './adds/TabHat';

    export default {
        name: 'FormGiaoPhanAdd',
        components: {
            TabGiaoHat
        },
        data() {
            return {
                fullPage: false,
                file: null
            };
        },
        computed: {
            ...mapState(MODULE_MODULE_GIAO_PHAN_ADD, {
                loading: state => state.loading
            }),
            ...mapGetters(MODULE_MODULE_GIAO_PHAN_ADD, [
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
            ...mapActions(MODULE_MODULE_GIAO_PHAN_ADD, [
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
            tab_mo_rong_title: 'Mở rộng',
            tab_bang_cap_title: 'Bằng Cấp',
            tab_chuc_thanh_title: 'Chức Thánh',
            tab_thuyen_chuyen_title: 'Thuyên Chuyển',
            tab_van_thu_title: 'Văn Thư',
            tab_special_info_title: 'Slide tin tức tiêu điểm',
            error_msg_system: 'Lỗi hệ thống !',
            isForm: 'add'
        }
    };
</script>
