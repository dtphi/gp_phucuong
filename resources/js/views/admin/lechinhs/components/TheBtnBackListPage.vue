<template>
    <a
        :href="_getHref()"
        data-toggle="tooltip"
        title="Trở về"
        class="btn btn-default">
        <i class="fa fa-reply"></i>
    </a>
</template>

<script>
    import {
        fn_get_base_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheBtnBackListPage',
        props: {},
        methods: {
            _getHref() {
                return fn_get_base_url() + `/admin/giao-phans`;
            }
        }
    };
</script>
