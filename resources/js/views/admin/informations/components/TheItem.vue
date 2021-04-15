<template>
    <tr>
        <td>{{_getNo()}}</td>
        <td class="text-center">                    
            <input type="checkbox" name="selected[]" :id="`info_select_id_${info.information_id}`" :value="info.information_id">
        </td>
        <td class="text-left">{{info.name}}</td>
        <td class="text-center">
            <div class="file animated fadeIn">
                <div class="file-preview">
                    <img :src="_getImgUrl()" class="thumb" />
                </div>
            </div>
        </td>
        <td class="text-center">{{_formatDate(info.date_available)}}</td>
        <td class="text-center">{{_formatDate(info.created_at)}}</td>
        <td class="text-right">
            <btn-edit
                :info-id="info.information_id"></btn-edit>
            <btn-delete
                :info-id="info.information_id"></btn-delete>
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
                    var id = (value.information_id && Number.isInteger(value.information_id));
                    var name = (value.name && value.name.length);

                    return (id && name)
                }
            },
            no : {
                default: 1
            }
        },
        computed: {
            ...mapState({
                meta: state => state.cfApp.collectionData
            })
        },
        data() {
            return {};
        },
        methods: {
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
