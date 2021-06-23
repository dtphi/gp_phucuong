<template>
    <div class="table-responsive">
        <table id="info-thuyen-chuyen-list" 
            class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">Key</td>
                    <td>Value</td>
                </tr>
            </thead>
            <info-item v-for="(item, idx) in lists" :item="item" :key="idx"></info-item>
            <tfoot>
                <tr>
                    <td></td>
                    <td class="text-right">
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

    export default {
        name: 'TheInfoList',
        components: {
            BtnAdd,
            InfoItem
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
