<template>
    <div id="content">
        <template v-if="_errors">
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p v-for="(err, idx) in _errorToArrs()" :key="idx">{{err}}</p>
            </div>
        </template>
        <template v-if="loading">
            <loading-over-lay
                :active.sync="loading"
                :is-full-page="fullPage"></loading-over-lay>
        </template>
        <template v-if="newsGroupAdd">
            <validation-observer
                ref="observerNewsGroup"
                @submit.prevent="_submitInfo">
                <div class="page-header">
                    <div class="container-fluid">
                        <div class="pull-right">
                            <button type="button" @click="_submitInfo"
                                    data-toggle="tooltip"
                                    :title="$options.setting.btn_save_txt"
                                    class="btn btn-primary"><i class="fa fa-save"></i></button>

                            <button type="button" @click="_submitInfoBack"
                                    data-toggle="tooltip"
                                    :title="$options.setting.btn_save_back_txt"
                                    class="btn btn-primary">{{$options.setting.btn_save_back_txt}}
                            </button>

                            <the-btn-back-list-page></the-btn-back-list-page>
                        </div>
                        <h1>{{$options.setting.panel_title}}</h1>
                        <breadcrumb></breadcrumb>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-pencil"></i>{{$options.setting.frm_title}}</h3>
                        </div>

                        <div class="panel-body">
                            <form class="form-horizontal">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab-general"
                                           data-toggle="tab">{{$options.setting.tab_general_title}}</a>
                                    </li>
                                    <li><a href="#tab-data" data-toggle="tab">{{$options.setting.tab_data_title}}</a>
                                    </li>
                                    <li><a href="#tab-design"
                                           data-toggle="tab">{{$options.setting.tab_design_title}}</a></li>
                                </ul>
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab-general">
                                        <div class="tab-content">
                                            <div class="form-group required">
                                                <label class="col-sm-2 control-label" for="input-category-name">Tên Nhóm Tin</label>
                                                <div class="col-sm-10">
                                                    <validation-provider
                                                        name="category_name"
                                                        rules="required|max:191"
                                                        v-slot="{ errors }">
                                                        <input type="text" v-model="newsGroupAdd.name"
                                                               placeholder="Tên nhóm tin" id="input-category-name"
                                                               class="form-control">

                                                        <span class="cms-text-red">{{ errors[0] }}</span>
                                                    </validation-provider>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-category-description">Mô tả</label>
                                                <div class="col-sm-10">
                                                    <tinymce
                                                        id="input-category-description"
                                                        :other_options="options"
                                                        v-model="newsGroupAdd.description"></tinymce>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label class="col-sm-2 control-label"
                                                       for="input-meta-title">Meta title</label>
                                                <div class="col-sm-10">
                                                    <validation-provider
                                                        name="meta_title"
                                                        rules="required|max:191"
                                                        v-slot="{ errors }">
                                                        <input type="text" v-model="newsGroupAdd.meta_title"
                                                               placeholder="Meta title" id="input-meta-title"
                                                               class="form-control">

                                                        <span class="cms-text-red">{{ errors[0] }}</span>
                                                    </validation-provider>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label 
                                                    for="input-meta-description" 
                                                    class="col-sm-2 control-label">{{$options.setting.tab_general_meta_description_txt}}</label>
                                                <div class="col-sm-10">
                                                    <validation-provider 
                                                        name="meta_description" 
                                                        rules="max:191" 
                                                        v-slot="{ errors }">
                                                        <textarea 
                                                            id="input-meta-description"
                                                            v-model="newsGroupAdd.meta_description" 
                                                            class="form-control"
                                                            :placeholder="$options.setting.tab_general_meta_description_txt"></textarea>

                                                        <span class="cms-text-red">{{ errors[0] }}</span>
                                                    </validation-provider>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label 
                                                    for="input-meta-keyword" 
                                                    class="col-sm-2 control-label">{{$options.setting.tab_general_key_word_txt}}</label>
                                                <div class="col-sm-10">
                                                    <validation-provider 
                                                        name="meta_keyword" 
                                                        rules="max:191" 
                                                        v-slot="{ errors }">
                                                        <textarea
                                                            id="input-meta-keyword"
                                                            v-model="newsGroupAdd.meta_keyword" 
                                                            class="form-control"
                                                            :placeholder="$options.setting.tab_general_key_word_txt"></textarea>

                                                        <span class="cms-text-red">{{ errors[0] }}</span>
                                                    </validation-provider>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label 
                                                    for="input-tag" 
                                                    class="col-sm-2 control-label">
                                                    <span data-toggle="tooltip" :data-original-title="$options.setting.tab_general_tag_tooltip_txt">{{$options.setting.tab_general_tag_txt}}</span>
                                                </label>
                                                <div class="col-sm-10">
                                                    <validation-provider 
                                                        name="tag" 
                                                        rules="max:191" 
                                                        v-slot="{ errors }">
                                                        <input
                                                            id="input-tag"
                                                            v-model="newsGroupAdd.tag" 
                                                            class="form-control"
                                                            :placeholder="$options.setting.tab_general_tag_txt">

                                                        <span class="cms-text-red">{{ errors[0] }}</span>
                                                    </validation-provider>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab-data">
                                        <category-autocomplete
                                            :category-id="newsGroupAdd.parent_id"></category-autocomplete>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="input-category-sort-order">Thứ tự</label>
                                            <div class="col-sm-10">
                                                <validation-provider
                                                        name="sort_order"
                                                        rules="numeric|max:191"
                                                        v-slot="{ errors }">
                                                    <input type="text" v-model="newsGroupAdd.sort_order" name="sort_order"
                                                           placeholder="Thứ tự hiển thị" id="input-category-sort-order"
                                                           class="form-control"/>

                                                    <span class="cms-text-red">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label"
                                                   for="input-category-status">Trạng thái</label>
                                            <div class="col-sm-10">
                                                <select v-model="newsGroupAdd.status" id="input-category-status"
                                                        class="form-control">
                                                    <option value="1" selected="selected">Xảy ra</option>
                                                    <option value="0">Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab-design">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <td class="text-left">Màn hình hiển thị</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-left">
                                                        <select v-model="newsGroupAdd.layout_id" class="form-control">
                                                            <option value="1">Trang chủ</option>
                                                            <option value="2">Trang Tin tức</option>
                                                            <option value="3">Trang Video</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </validation-observer>
        </template>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import TheBtnBackListPage from './components/TheBtnBackListPage';
    import tinymce from 'vue-tinymce-editor';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import CategoryAutocomplete from 'com@admin/Search/CategoryAutocomplete';
    import {
        fn_get_tinymce_langs_url
    } from '@app/api/utils/fn-helper';

    import {
        MODULE_NEWS_CATEGORY_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_LOADING,
        ACTION_INSERT_NEWS_GROUP,
        ACTION_RESET_NOTIFICATION_INFO,
        ACTION_INSERT_NEWS_GROUP_BACK
    } from 'store@admin/types/action-types';

    export default {
        name: 'CategoryAddPage',
        components: {
            TheBtnBackListPage,
            Breadcrumb,
            CategoryAutocomplete,
            tinymce
        },
        data() {
            return {
                fullPage: false,
                options: {
                    language_url: fn_get_tinymce_langs_url('vi_VN'),
                }
            };
        },
        computed: {
            ...mapState(MODULE_NEWS_CATEGORY_ADD, {
                loading: state => state.loading,
                errors: state => state.errors
            }),
            ...mapGetters(MODULE_NEWS_CATEGORY_ADD, [
                'newsGroupAdd',
                'insertSuccess'
            ]),
            _errors() {
                return this.errors.length;
            }
        },
        watch: {
            'insertSuccess'(newValue, oldValue) {
                if (newValue) {
                    this._notificationUpdate(newValue);
                }
            }
        },
        methods: {
            ...mapActions(MODULE_NEWS_CATEGORY_ADD, [
                ACTION_SET_LOADING,
                ACTION_INSERT_NEWS_GROUP,
                ACTION_INSERT_NEWS_GROUP_BACK,
                ACTION_RESET_NOTIFICATION_INFO
            ]),
            _errorToArrs() {
                let errs = [];
                if (this.errors.length && typeof this.errors[0].messages !== "undefined") {
                    errs = Object.values(this.errors[0].messages);
                }

                if (Object.entries(errs).length === 0 && this.errors.length) {
                    errs.push(this.$options.setting.error_msg_system);
                }

                return errs;
            },
            async _submitInfo() {
                const _self = this;

                await _self.$refs.observerNewsGroup.validate().then((isValid) => {
                    if (isValid) {
                        _self.[ACTION_INSERT_NEWS_GROUP](_self.newsGroupAdd);
                    }
                });
            },

            async _submitInfoBack() {
                const _self = this;

                await _self.$refs.observerNewsGroup.validate().then((isValid) => {
                    if (isValid) {
                        _self.[ACTION_INSERT_NEWS_GROUP_BACK](_self.newsGroupAdd);
                    }
                });
            },
            _notificationUpdate(notification) {
                this.$notify(notification);
                this.[ACTION_RESET_NOTIFICATION_INFO]('');
            }
        },
        setting: {
            panel_title: 'Danh Mục Tin',
            frm_title: 'Thêm danh mục tin',
            btn_save_txt: 'Lưu',
            btn_save_back_txt: 'Lưu trở về danh sách',
            tab_general_title: 'Tổng quan',
            tab_data_title: 'Mở rộng',
            tab_design_title: 'Màn hình',
            error_msg_system: 'Lỗi hệ thống !',
            tab_general_key_word_txt: 'Từ khóa mô tả',
            tab_general_meta_title_txt: 'Thẻ meta tiêu đề',
            tab_general_meta_description_txt: 'Thẻ meta mô tả',
            tab_general_tag_txt: 'Tags',
            tab_general_tag_tooltip_txt: 'Ngăn cách bởi dấu phẩy'
        }
    };
</script>
