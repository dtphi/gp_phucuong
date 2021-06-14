<template>
    <button @click="_showModal()"
            data-toggle="tooltip" title=""
            class="btn btn-primary"
            data-original-title="Thêm Tin Tức">
        <i class="fa fa-plus"></i>
    </button>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheButtonAdd',
        props: {
            isRedirect: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            _showModal() {
                if (this.isRedirect) {
                    return this._redirectUrl();
                } 
            },
            _redirectUrl() {
                return fn_redirect_url('admin/linh-mucs/add');
            },
            _pushAddPage() {
                this.$router.push(`/admin/linh-mucs/add`);
            }
        }
    };
</script>
