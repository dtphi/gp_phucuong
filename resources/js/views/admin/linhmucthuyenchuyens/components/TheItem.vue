<template>
    <tr>
        <td>{{_getNo()}}</td>
        <td class="text-center">
            <input type="checkbox" name="selected[]"
                   :id="`info_select_id_${info.id}`"
                   :value="info.id">
        </td>
        <td class="text-left">
            <a :href="info.linh_muc_url">{{info.ten_linh_muc}}</a>
        </td>
        <td class="text-left">{{info.fromgiaoxuName}}</td>
        <td class="text-left">{{info.fromchucvuName}}</td>
        <td class="text-left">{{info.label_from_date}}</td>
        <td class="text-left">{{info.ducchaName}}</td>
        <td class="text-left">{{info.giaoxuName}}</td>
        <td class="text-left">{{info.label_to_date}}</td>
        <td class="text-left">{{info.chucvuName}}</td>
        <td class="text-center">{{info.ghi_chu}}</td>
        <td class="text-center">{{info.active}}</td>
        
        <td class="text-right">
            <a href="javascript:void(0);" data-toggle="tooltip"
                @click.prevent="_showModal()"
                class="btn btn-default cms-btn"
                data-original-title="Sửa Tin"><i class="fa fa-edit"/>
            </a>
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
    import BtnDelete from './TheBtnDelete';
    import {
        fn_get_base_url_image,
        fn_format_dd_mm_yyyy
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheItem',
        components: {
            BtnDelete
        },
        props: {
            info: {
                type: Object
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
            _showModal() {
                this.$emit('show-modal-edit', this.info);
            }
        }
    };
</script>
