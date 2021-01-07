<template>
    <div class="sales-cont" :style="'min-height: ' + height" v-if="!loading">
        <div class="div-content bg-white p-2 p-md-4 shadow">
            <b-row class="row frm_search" align-h="end">
                <button v-b-toggle.frm_search class="btn white-btn-custom mb-3 search-fnc-btn" :class="{ active: search.isSearch }">
                    <i class="fas fa-search"></i>
                    <span>検索</span>
                </button>
            </b-row>
            <b-collapse id="frm_search">
                <b-row class="row frm-search" align-h="end">
                    <b-col cols="12" sm="6" lg="5" xl="4" class="mb-2">
                        <div class="month-picker">
                            <i class="fas fa-calendar-alt"></i>
                            <vue-monthly-picker
                                v-model="month" 
                                :monthLabels="['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']"
                                placeHolder="”発注日”で検索"
                                @selected="onMonthChange"
                            >
                            </vue-monthly-picker>
                        </div>
                    </b-col>
                    <b-col cols="12" sm="6" lg="4" xl="4">
                        <b-input-group class="mb-3">
                            <b-input-group-prepend>
                                <b-input-group-text>
                                    <i class="fas fa-search"></i>
                                </b-input-group-text>
                            </b-input-group-prepend>

                            <b-form-input type="text" v-model="search" maxlength="20" placeholder="”商品”で検索" @keypress="onSearchPress"></b-form-input>

                            <b-input-group-append>
                                <b-button class="btn blue-btn-custom custom-btn" :disabled="isLoading" @click="onSearch">検索
                                </b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-col>
                    <b-button class="btn blue-btn-custom reset-btn" :disabled="isLoading" @click="onClear">検索条件をクリア</b-button>
                </b-row>
            </b-collapse>

            <v-server-table class="sm-tbl" ref="tablePurchaseHistories" :columns="columns" :options="options"></v-server-table>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import VueMonthlyPicker from 'vue-monthly-picker'
    import * as API from '../../../stores/API';
    import productInfo from './components/ProductInfo';

    export default {
        name: 'PurchaseList',
        components: {
            VueMonthlyPicker
        },
        data() {
            return {
                columns: [ 'order_date', 'productInfo' ],
                options: {
                    storeCode: null,
                    columnsClasses: {
                        order_date: 'order-date-col ',
                        productInfo: 'order-prod-col',
                    },
                    headings: {
                        order_date: '発注日',
                        productInfo: '商品',
                    },
                    orderBy: {
                        ascending: false,
                        column: 'order_date'
                    },
                    pagination: {
                        dropdown: false
                    },
                    perPageValues: [ 10 ],
                    requestAdapter(data) {
                        let request = {
                            sort: data.orderBy,
                            direction: data.ascending ? 'asc' : 'desc'
                        };

                        if (data.page !== 1) {
                            request.page = data.page;
                        }
                        if (data.query !== '') {
                            const query    = data.query.split('<split>');
                            request.month  = query[0];
                            request.search = query[1];
                        }

                        request.code = this.storeCode;

                        return request;
                    },
                    requestFunction(data) {
                        return axios.get(API.API_STORE_PURCHASE_HISTORY_LIST, { params: data });
                    },
                    resizableColumns: false,
                    responseAdapter(resp) {
                        const data = this.getResponseData(resp);

                        return {
                            data: data.data.histories.data,
                            count: data.data.histories.total
                        };
                    },
                    skin: 'table table-striped table-bordered',
                    sortIcon: {
                        base: 'fas',
                        up: 'fa-sort-amount-down-alt',
                        down: 'fa-sort-amount-up',
                        is: ''
                    },
                    sortable: [ 'order_date' ],
                    templates: {
                        productInfo
                    },
                    texts: {
                        count: '',
                        noResults: '検索結果がありません'
                    }
                },
                search: '',
                month: '',
                height: '0',
            };
        },
        computed: {
            ...mapGetters('store.auth', [ 'store' ]),
            loading() {
                if (this.store) {
                    this.options.storeCode = this.store.code;
                    return false;
                }
                return true;
            },
            getMonth() {
                return this.month ? this.month.format() : '';
            }
        },
        mounted() {
            this.height = this.calculateHeight();
        },
        methods: {
            onSearch() {
                this.$refs.tablePurchaseHistories.setFilter(this.getMonth + '<split>' + this.search);
            },
            onClear() {
                this.search = '';
                this.month = '';
                this.$refs.tablePurchaseHistories.setFilter('');
            },
            onMonthChange() {
                this.$refs.tablePurchaseHistories.setFilter(this.getMonth + '<split>' + this.search);
            },
            onSearchPress(event) {
                if (event.keyCode === 13 && !this.isLoading) {
                    event.preventDefault();
                    this.$refs.tablePurchaseHistories.setFilter(this.getMonth + '<split>' + this.search);
                }
            }
        }
    };
</script>