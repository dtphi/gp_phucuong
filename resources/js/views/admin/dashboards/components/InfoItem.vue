<template>
    <tr>
        <td>{{_getNo()}}</td>
        <td class="text-left">
            <a
                :href="_getHref()">{{info.name}}</a></td>
        <td class="text-center" style="width:7%">
            <img
                :src="_getImgUrl()"
                class="img-thumbnail"/>
        </td>
        <td class="text-center">{{_formatDate(info.created_at)}}</td>
    </tr>
</template>

<script>
    import {
        mapState
    } from 'vuex';
    import {
        fn_get_base_url_image,
        fn_format_dd_mm_yyyy
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'InfoItem',
        props: {
            info: {
                type: Object,
                validator: function (value) {
                    var id = (value.information_id && Number.isInteger(value.information_id));
                    var name = (value.name && value.name.length);

                    return (id && name)
                }
            },
            no: {
                default: 1
            }
        },
        computed: {
            ...mapState({
                meta: state => state.cfApp.collectionData
            })
        },
        methods: {
            _getHref() {
                return `/admin/informations/edit/${this.info.information_id}`;
            },
            _getImgUrl() {
                return fn_get_base_url_image(this.info.image);
            },
            _getNo() {
                return (parseInt(this.no) + parseInt(this.meta.from));
            },
            _formatDate(date) {
                return fn_format_dd_mm_yyyy(date);
            }
        }
    };
</script>
