<template>
    <div class="table-responsive">
        <table id="info-van-thu-list" class="table table-striped table-bordered table-hover">
            <thead>
                 <tr>
                    <td colspan="5" class="text-right">
                        <btn-add></btn-add>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Tiêu đề</td>
                    <td class="text-left">Loại</td>
                    <td class="text-left">Ghi chú</td>
                    <td class="text-left">Trạng thái</td>
                    <td class="text-right">{{$options.setting.info_action_title}}</td>
                </tr>
            </thead>
            <tbody v-for="(item, idx) in lists" :key="idx">
                <info-item v-if="item.isEdit" :item="item"></info-item>
                <info-new-item v-else :item="item"></info-new-item>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">
                        <btn-add></btn-add>
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
