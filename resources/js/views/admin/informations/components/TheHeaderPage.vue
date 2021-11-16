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
                <button type="button"
                        data-toggle="tooltip" title=""
                        class="btn btn-danger"
                        onclick="confirm('Are you sure?') ? $('#form-category').submit() : false;"
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
        mapState,
        mapActions
    } from 'vuex';
    import BtnAdd from './TheBtnAdd';
    import Perpage from 'com@admin/Pagination/SelectPerpage';
    import ListSearch from 'com@admin/Search';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        MODULE_INFO
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST
    } from 'store@admin/types/action-types';
    import {
        config
    } from '@app/common/config';

    export default {
        name: 'InformationHeaderPage',
        components: {
            BtnAdd,
            Perpage,
            ListSearch,
            Breadcrumb
        },
        methods: {
            ...mapState({
                perPage: state => state.cfApp.perPage
            }),
            ...mapActions(MODULE_INFO, {
                'getInfoList': ACTION_GET_INFO_LIST
            }),
            _pushAddPage() {
                this.$router.push(`/${config.adminPrefix}/informations/add`);
            },
            _refreshList() {
                const params = {
                    perPage: this.perPage
                };
                this.getInfoList(params);
            }
        },
        setting: {
            title: 'Tin Tức',
            refresh_txt: 'Tải lại danh sách'
        }
    };
</script>
