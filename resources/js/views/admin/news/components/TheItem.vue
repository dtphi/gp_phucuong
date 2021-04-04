<template>
    <tr>
        <td>{{_getNo()}}</td>
        <td class="text-center">                    
            <input type="checkbox" name="selected[]" :id="`info_select_id_${info.id}`" :value="info.id">
        </td>
        <td>{{info.newsname}}</td>
        <td>{{info.description}}</td>
        <td>{{_formatDate(info.created_at)}}</td>
        <td>
            <div class="file animated fadeIn">
                <div class="file-preview">
                    <img :src="_getImgUrl()" class="thumb" />
                </div>
            </div>
        </td>
        <td class="text-right">
            <btn-edit
                :info-id="info.id"></btn-edit>
            <btn-delete
                :info-id="info.id"></btn-delete>
        </td>
    </tr>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    import BtnEdit from './TheBtnEdit';
    import BtnDelete from './TheBtnDelete';
    import {
        fn_get_base_url_image,
        fn_format_dd_mm_yyyy
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheItem',
        components: {
            BtnEdit,
            BtnDelete
        },
        props: {
            info: {
                type: Object,
                validator: function (value) {
                    var id = (value.id && Number.isInteger(value.id));
                    var name = (value.newsname && value.newsname.length);

                    return (id && name)
                }
            },
            no : {
                default: 1
            }
        },
        computed: {
            ...mapState({
                meta: state => state.cfApp.meta
            })
        },
        data() {
            return {};
        },
        methods: {
            _getImgUrl() {
                return fn_get_base_url_image(this.info.picture);
            },

            _getNo() {
                return (this.no + this.meta.from);
            },

            _formatDate(date) {
                return fn_format_dd_mm_yyyy(date);
            }
        }
    };
</script>
