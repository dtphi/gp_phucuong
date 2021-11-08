<template>
    <button @click="_redirectUrl()"
            data-toggle="tooltip" title=""
            class="btn btn-primary"
            data-original-title="Thêm Giáo Hạt">
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
        name: 'TheButtonAdd',
        props: {
            isRedirect: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            _redirectUrl() {
                return fn_redirect_url(`${config.adminPrefix}/giao-hats/add`);
            },
        }
        
    };
</script>
