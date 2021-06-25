<template>
    <div class="table-responsive">
        <table
                class="table table-striped table-bordered table-hover"
                v-for="(item, idx) in lists" :key="idx">
            <thead>
                <tr>
                    <td colspan="3" class="text-center">
                        Giáo Hat: {{item.hatName}}
                    </td>
                </tr>
                <tr>
                    <td style="width:50%" class="text-left">Công đoàn tu sĩ</td>
                    <td style="width:20%" class="text-left">Trình trạng</td>
                    <td style="width:30%" class="text-right">Thực hiện</td>
                </tr>
            </thead>
            <tbody  v-for="(congDts, idx) in item.cong_doan_tu_sis" :key="idx">
                <info-item
                    v-if="congDts.isEdit"
                    :hat="item" :item="congDts"></info-item>
                <info-new-item
                    v-else
                    :hat="item" :item="congDts"></info-new-item>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">
                        <btn-add :giao-hat="item"></btn-add>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>    
</template>

<script>
    import BtnAdd from './BtnAdd';
    import InfoItem from './InfoItem';
    import InfoNewItem from './InfoNewItem';

    export default {
        name: 'TheInfoList',
        components: {
            BtnAdd,
            InfoItem,
            InfoNewItem
        },
        props: {
            lists: {
                default: {}
            }
        },
        setting: {
            info_title: 'Tiêu đề',
            info_url_title: 'Url tiêu đề',
            info_author_titile: 'Tác giả',
            info_sort_order_title: 'Sắp xếp',
            
            info_action_title: 'Thực hiện',
            btn_image_sub_remove_txt: 'Xóa',
            btn_image_sub_add_txt: 'Thêm hình ảnh'
        }
    };
</script>
