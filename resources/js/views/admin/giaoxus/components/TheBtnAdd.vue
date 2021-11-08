<template>
    <button @click="_redirectUrl()"
            data-toggle="tooltip" title=""
            class="btn btn-primary"
            data-original-title="Thêm Giáo Xứ">
        <i class="fa fa-plus"></i>
    </button>
</template>

<script>
    import {
        config
    } from '@app/common/config';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheButtonAddGiaoXu',
        props: {
            isRedirect: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            _redirectUrl() {
                return fn_redirect_url(`${config.adminPrefix}/giao-xus/add`);
            },
        }
    };
</script>
