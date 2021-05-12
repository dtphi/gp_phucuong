<template>
    <div class="row">
        <template>
            <div class="col-sm-6 text-left">
                <div class="dataTables_info">
                    {{_getTextPaginationCollection()}}
                </div>
            </div>
            <div class="col-sm-6 text-right">
                <div class="dataTables_paginate paging_simple_numbers"
                     v-if="Object.keys(_collectionData).length">
                    <collection-pagination
                        class="mb-0"
                        :data="_collectionData"
                        @pagination-change-page="_getCollectionResults"
                        :limit="limit"
                        :show-disabled="showDisabled"
                        :size="size"
                        :align="align"></collection-pagination>

                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import {
        mapGetters
    } from 'vuex';
    import CollectionPagination from './CollectionPagination';

    export default {
        name: 'Pagination',
        props: {
            isResource: {
                type: Boolean,
                default: true,
            }
        },
        components: {
            CollectionPagination
        },
        data() {
            return {
                limit: 3,
                showDisabled: false,
                size: 'small',
                align: 'right'
            }
        },
        computed: {
            ...mapGetters([
                'collectionPaginationData',
                'moduleNameActive',
                'moduleActionListActive'
            ]),
            _collectionData() {
                return this.collectionPaginationData;
            }
        },
        methods: {
            _paginationMsg(from, to, total) {
                var textShow = "Hiển thị 0 đến 0 của 0";
                if (typeof from !== "undefined" && typeof from !== null) {
                    textShow = `Hiển thị ${from} đến ${to} của ${total}`;
                }

                return textShow;
            },
            _getTextPaginationCollection() {
                const from = this.collectionPaginationData.from;
                const to = this.collectionPaginationData.to;
                const total = this.collectionPaginationData.total;

                return this._paginationMsg(from, to, total);
            },
            _getCollectionResults(page) {
                const _self = this;
                if (!page) {
                    page = 1;
                }

                const actionName = _self.moduleNameActive + '/' + _self.moduleActionListActive;
                _self.$store.dispatch(actionName, {
                    perPage: parseInt(_self.collectionPaginationData.per_page),
                    page: parseInt(page),
                    ...this.$route.params
                });
            }
        },
        watch: {
            limit(newVal) {
                this.limit = parseInt(newVal);
                if (this.limit < 0) {
                    this.limit = 0;
                }
            }
        },
    };
</script>
