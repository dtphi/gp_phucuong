<template>
    <tr>
        <td>{{_getNo()}}</td>
        <td class="text-center">
            <input type="checkbox" name="selected[]"
                   :id="`info_select_id_${info.id}`"
                   :value="info.id">
        </td>
        <td class="text-left">{{info.name}}</td>
        <td>{{info.dia_chi}}</td>
        <td>
            <div v-html="info.ghi_chu"></div>
        </td>
        <td class="text-center">{{info.sort_id}}</td>
        <td class="text-center">{{info.active_text}}</td>
        
        <td class="text-right">
            <a href="javascript:void(0);" data-toggle="tooltip"
                @click.prevent="_showModal"
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
                type: Object,
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
