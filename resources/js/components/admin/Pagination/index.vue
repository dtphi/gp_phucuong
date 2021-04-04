<template>
    <div class="row">
        <div class="col-sm-6 text-left">
            <div class="dataTables_info">
                {{_getTextPagination()}}
            </div>
        </div>
        <div class="col-sm-6 text-right">
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
        mapGetters
    } from 'vuex';
    import ResourcePagination from './ResourcePagination';

    export default {
        name: 'Pagination',

        components: { ResourcePagination },

        data () {
            return {
                limit: 5,
                showDisabled: true,
                size: 'default',
                align: 'right'
            }
        },

        computed: {
            ...mapGetters(['resourcePaginationData', 'moduleNameActive', 'moduleActionListActive']),

            _resourceData() {
                return this.resourcePaginationData;
            }
        },

        methods: {

            _getTextPagination() {
                //console.log(`I ${'>:D<'} C#`)
                const from = this.resourcePaginationData.meta.from;
                const to = this.resourcePaginationData.meta.to;
                const total = this.resourcePaginationData.meta.total;

                var textShow = "Showing 0 to 0 of 0 entries";
                if (typeof from !== "undefined" && typeof from !== null) {
                    textShow = `Showing ${from} to ${to} of ${total} entries`;
                }

                return textShow;
            },

            _getResourceResults (page) {
                const _self = this;
                if (!page) {
                    page = 1;
                }
                const actionName = _self.moduleNameActive + '/' + _self.moduleActionListActive;
                _self.$store.dispatch(actionName, {
                    perPage: _self.resourcePaginationData.meta.per_page,
                    page: page
                });
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
