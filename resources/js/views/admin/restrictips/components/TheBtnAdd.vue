<template>
    <button @click="_redirectUrl()"
            data-toggle="tooltip" title=""
            class="btn btn-primary"
            data-original-title="Thêm IP">
        <i class="fa fa-plus"></i>
    </button>
</template>

<script>
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'AddRestrictIp',
        props: {
            isRedirect: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            _redirectUrl() {
                return fn_redirect_url('admin/restrict-ips/add');
            },
        }
    };
</script>
