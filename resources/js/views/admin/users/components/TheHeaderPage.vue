<template>
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <btn-add></btn-add>
                <button
                    @click="_refreshList()"
                    data-toggle="tooltip"
                    :title="$options.setting.refresh_txt"
                    class="btn btn-default"
                    :data-original-title="$options.setting.refresh_txt">
                    <i class="fa fa-refresh"></i>
                </button>

                <button
                    type="button"
                    data-toggle="tooltip"
                    title=""
                    class="btn btn-danger"
                    @click="_deleteMultiple()"
                    data-original-title="Delete">
                    <i class="fa fa-trash-o"></i>
                </button>
            </div>
            <h1>{{$options.setting.title}}</h1>
            <breadcrumb></breadcrumb>
            <ul class="cms-breadcrumb">
                <li>
                    <perpage></perpage>
                </li>
                <li>
                    <list-search></list-search>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import BtnAdd from './TheBtnAdd';
    import Perpage from 'com@admin/Pagination/SelectPerpage';
    import ListSearch from 'com@admin/Search';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        MODULE_USER
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_USER_LIST
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheUserHeaderPage',
        components: {
            BtnAdd,
            Perpage,
            ListSearch,
            Breadcrumb
        },
        methods: {
            ...mapActions(MODULE_USER, [
                ACTION_GET_USER_LIST
            ]),
            _refreshList() {
                this.[ACTION_GET_USER_LIST]();
            },
            _deleteMultiple() {
                confirm(this.$options.setting.delete_warning_txt) ? $('#form-category').submit() : false;
            }
        },
        setting: {
            title: 'Người Dùng',
            refresh_txt: 'Tải lại danh sách',
            delete_warning_txt: 'Bạn muốn xóa tất cả các mục đã chọn ?'
        }
    };
</script>
