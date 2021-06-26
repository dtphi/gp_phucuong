<template>
    <tr>
        <td>{{_getNo()}}</td>
        <td class="text-center">
            <input type="checkbox" name="selected[]"
                   :id="`info_select_id_${info.id}`"
                   :value="info.id">
        </td>
        <td class="text-left">{{_getTen()}}</td>
        <td class="text-center" style="width:7%">
            <img :src="info.imgThum" class="img-thumbnail"/>
        </td>
        <td class="text-center">{{info.phone}}</td>
        <td class="text-center">{{info.email}}</td>
        <td class="text-center">{{_formatDate(info.ngay_sinh)}}</td>
        <td class="text-center">{{info.trieu_dong}}</td>
        <td class="text-center">{{info.active}}</td>
        
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
                    var name = (value.ten && value.ten.length);

                    return (id && name)
                }
            },
            no: {
                default: 1
            }
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapState({
                meta: state => state.cfApp.collectionData
            }),
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
            },
            _getTen() {
                return `${this.info.ten_thanh}-${this.info.ten}`;
            }
        }
    };
</script>
