<template>
    <button @click="_redirectUrl()"
            data-toggle="tooltip" title=""
            class="btn btn-primary"
            data-original-title="Thêm Dòng">
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
        name: 'TheButtonAddDong',
        props: {
            isRedirect: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            _redirectUrl() {
                return fn_redirect_url('admin/dongs/add');
            },
        }
    };
</script>
