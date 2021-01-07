<template>
    <div class="sales-cont" :style="'min-height: ' + height">
        <div class="div-content bg-white p-4 shadow">
            <b-row class="row frm-search" align-h="between">
                <b-col cols="12" sm="5" lg="3" class="mb-2">
                    <b-link :to="{ name: 'admin.stores.create' }" role="button" class="btn blue-btn-custom btn-block">
                        <i class="fas fa-plus mr-2"></i> 新規登録
                    </b-link>
                </b-col>
                <b-col cols="12" sm="7" lg="4">
                    <b-input-group class="mb-3">
                        <b-input-group-prepend>
                            <b-input-group-text>
                                <i class="fas fa-search"></i>
                            </b-input-group-text>
                        </b-input-group-prepend>

                        <b-form-input type="text" v-model="search" maxlength="20" placeholder="検索する" @keypress="onSearchPress"></b-form-input>

                        <b-input-group-append>
                            <b-button class="btn blue-btn-custom custom-btn" :disabled="isLoading" @click="onSearch">検索</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
            </b-row>

            <v-server-table ref="tableStores" :columns="columns" :options="options"></v-server-table>
        </div>

        <ModalAlert title="アカウント削除" message="この販売店は既に削除されています。"></ModalAlert>
    </div>
</template>

<script>
    import * as API from '../../../stores/API';
    import ModalAlert from '../../modals/ModalAlert';
    import btnDetail from './components/ButtonDetail';

    export default {
        name: 'StoresList',
        components: {
            ModalAlert
        },
        data() {
            return {
                columns: [ 'code', 'name', 'sale_person', 'btnDetail' ],
                options: {
                    columnsClasses: {
                        code: 'col-w-3',
                        name: 'col-w-3',
                        sale_person: 'col-w-3',
                        btnDetail: 'text-center col-w-1'
                    },
                    headings: {
                        code: '販売店コード',
                        name: '販売店名',
                        sale_person: '営業担当者',
                        btnDetail: 'アクション'
                    },
                    orderBy: {
                        ascending: false,
                        column: 'code'
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
                            request.q = data.query;
                        }
                        return request;
                    },
                    requestFunction(data) {
                        return axios.get(API.API_ADMIN_STORES_LIST, { params: data });
                    },
                    resizableColumns: false,
                    responseAdapter(resp) {
                        const data = this.getResponseData(resp);

                        return {
                            data: data.data.stores.data,
                            count: data.data.stores.total
                        };
                    },
                    skin: 'table table-striped table-bordered',
                    sortIcon: {
                        base: 'fas',
                        up: 'fa-sort-amount-down-alt',
                        down: 'fa-sort-amount-up',
                        is: ''
                    },
                    sortable: [ 'code' ],
                    templates: {
                        btnDetail
                    },
                    texts: {
                        count: '',
                        noResults: '検索結果がありません'
                    }
                },
                search: '',
                height: '0'
            };
        },
        mounted() {
            this.height = this.calculateHeight();
        },
        methods: {
            onSearch() {
                this.$refs.tableStores.setFilter(this.search);
            },
            onSearchPress(event) {
                if (event.keyCode === 13 && !this.isLoading) {
                    event.preventDefault();
                    this.$refs.tableStores.setFilter(this.search);
                }
            }
        }
    };
</script>

<style scoped>

</style>