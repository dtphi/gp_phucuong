<template>
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button data-toggle="tooltip"
                    @click.prevent="_showModal()"
                    class="btn btn-primary cms-btn"
                    data-original-title="Thêm Ngày Lễ"><i class="fa fa-plus"/>
                </button>
                <button
                    @click="_refreshList()"
                    data-toggle="tooltip"
                    :title="$options.setting.refresh_txt"
                    class="btn btn-default"
                    :data-original-title="$options.setting.refresh_txt">
                    <i class="fa fa-refresh"></i>
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
    import Perpage from 'com@admin/Pagination/SelectPerpage';
    import ListSearch from 'com@admin/Search';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import {
        MODULE_MODULE_NGAY_LE,
    } from 'store@admin/types/module-types';

    import {
        ACTION_GET_INFO_LIST
    } from 'store@admin/types/action-types';

    export default {
        name: 'TheHeaderPage',
        components: {
            Perpage,
            ListSearch,
            Breadcrumb
        },
        computed: {
            ...mapState({
                perPage: state => state.cfApp.perPage
            }),
        },
        methods: {
            ...mapActions(MODULE_MODULE_NGAY_LE, {
                'getInfoList': ACTION_GET_INFO_LIST
            }),
            _showModal() {
                this.$emit('show-modal-add');
            },
            _refreshList() {
                const params = {
                    perPage: this.perPage
                };
                this.getInfoList();
            }
        },
        setting: {
            title: 'Ngày Lễ',
            refresh_txt: 'Tải lại danh sách'
        }
    };
</script>