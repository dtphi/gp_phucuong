<template>
	<div id="content">
        <template v-if="loading">
            <loading-over-lay :active.sync="loading"
                              :is-full-page="fullPage"></loading-over-lay>
        </template>
        <template v-else>
            <validation-observer ref="observerNewsGroup" @submit.prevent="_submitInfo">
                <div class="page-header">
                    <div class="container-fluid">
                      <div class="pull-right">
                        <button type="button" @click="_submitInfo"
                            data-toggle="tooltip" 
                            title="Lưu" 
                            class="btn btn-primary"><i class="fa fa-save"></i></button>

                        <the-btn-back-list-page></the-btn-back-list-page>
                      </div>
                      <h1>Nhóm Tin</h1>
                      <breadcrumb></breadcrumb>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-pencil"></i>Thêm nhóm tin</h3>
                      </div>
                    
                    <div class="panel-body">
                        <form class="form-horizontal">
                          <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab-general" data-toggle="tab">Tổng quan</a>
                            </li>
                            <li><a href="#tab-data" data-toggle="tab">Dữ liệu</a></li>
                            <li><a href="#tab-design" data-toggle="tab">Màn hình</a></li>
                          </ul>
                          <div class="tab-content">
                            <div class="tab-pane active" id="tab-general">
                              <div class="tab-content">
                                  <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-name">Tên Nhóm Tin</label>
                                    <div class="col-sm-10">
                                      <input type="text" v-model="newsGroupAdd.name" placeholder="Tên nhóm tin" id="input-name" class="form-control">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-description">Mô tả</label>
                                    <div class="col-sm-10">
                                      <tinymce 
                                            id="input-description" 
                                            :other_options="options"
                                            v-model="newsGroupAdd.description"></tinymce>
                                    </div>
                                  </div>
                                  <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-meta-title">Meta title</label>
                                    <div class="col-sm-10">
                                      <input type="text" v-model="newsGroupAdd.meta_title" placeholder="Meta title" id="input-meta-title" class="form-control">
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="tab-data">
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-parent">Nhóm tin cha</label>
                                <div class="col-sm-10">
                                  <input type="text" v-model="newsGroupAdd.parent_id" placeholder="Nhóm tin cha" id="input-parent" class="form-control" />
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-sort-order">Thứ tự</label>
                                <div class="col-sm-10">
                                  <input type="text" v-model="newsGroupAdd.sort_order" name="sort_order" placeholder="Thứ tự hiển thị" id="input-sort-order" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status">Trạng thái</label>
                                <div class="col-sm-10">
                                  <select v-model="newsGroupAdd.status" id="input-status" class="form-control">
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
    import {
        fn_get_tinymce_langs_url
    } from '@app/api/utils/fn-helper';

    import {
        MODULE_NEWS_CATEGORY_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_LOADING,
        ACTION_INSERT_NEWS_GROUP
    } from 'store@admin/types/action-types';

    export default {
        name: 'CategoryAddPage',
        components: {
            TheBtnBackListPage,
            Breadcrumb,
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
                loading: state => state.loading
            }),
            ...mapGetters(MODULE_NEWS_CATEGORY_ADD, [
                'newsGroupAdd'
            ]),
        },
        methods: {
            ...mapActions(MODULE_NEWS_CATEGORY_ADD, [
                ACTION_SET_LOADING,
                ACTION_INSERT_NEWS_GROUP,
            ]),
            async _submitInfo() {
                const _self = this;
                _self.[ACTION_SET_LOADING](true);
                await _self.$refs.observerNewsGroup.validate().then((isValid) => {
                    if (isValid) {
                        _self.[ACTION_INSERT_NEWS_GROUP](_self.newsGroupAdd);
                    } else {
                        _self.[ACTION_SET_LOADING](false);
                    }
                });
            }
        },
        setting: {
            title: 'News Groups List'
        }
    };
</script>
