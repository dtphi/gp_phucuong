<template>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info">
                {{_getTextPagination()}}
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers">
                <resource-pagination
                        :data="_resourceData"
                        @pagination-change-page="_getResourceResults"
                        :limit="_resourceData.meta.per_page"
                        :show-disabled="showDisabled"
                        :size="size"
                        :align="align"></resource-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import ResourcePagination from './ResourcePagination';
    import {
        MODULE_INFO,
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_INFO_LIST,
    } from 'store@admin/types/action-types';

    export default {
        name: 'Pagination',

        components: { ResourcePagination },

        data () {
            return {
                limit: 15,
                showDisabled: true,
                size: 'default',
                align: 'right'
            }
        },

        computed: {
            ...mapGetters(['resourcePaginationData']),

            _resourceData() {
                return this.resourcePaginationData;
            }
        },

        methods: {
            ...mapActions(MODULE_INFO, [ACTION_GET_INFO_LIST]),

            _getTextPagination() {
                //console.log(`I ${'>:D<'} C#`)
                const from = this.resourcePaginationData.meta.from;
                const to = this.resourcePaginationData.meta.to;
                const total = this.resourcePaginationData.meta.total;

                return `Showing ${from} to ${to} of ${total} entries`;
            },

            _getResourceResults (page) {
                const _self = this;
                if (!page) {
                    page = 1;
                }
                _self.[ACTION_GET_INFO_LIST]({page: page});
            }
        },

         watch: {
            limit (newVal) {
                this.limit = parseInt(newVal);
                if (this.limit < 0) {
                    this.limit = 0;
                }
            }
        },
    };
</script>
