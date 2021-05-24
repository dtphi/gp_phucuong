<template>
    <div class="table-responsive">
        <table id="info-list" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">{{$options.setting.image_title}}</td>
                    <td class="text-left">{{$options.setting.image_capture_title}}</td>
                    <td class="text-left">{{$options.setting.image_sort_order_title}}</td>
                    <td calss="text-right">{{$options.setting.image_action_title}}</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, idx) in lists.value" :key="idx">
                    <td>
                         <div class="file animated fadeIn" style="height: 61px">
                            <div class="file-preview" @click="_addImage">
                                <img :src="_getImgUrl()" class="thumb"/>
                            </div>
                        </div>
                        <!--<input v-model="item.title" class="form-control" type="text"/>-->
                    </td>
                    <td>
                        <input v-model="item.url_title" class="form-control" type="text"/>
                    </td>
                    <td>
                        <input v-model="item.sort_order" class="form-control" type="number"/>
                    </td>
                    <td>
                        <button 
                            type="button" 
                            data-toggle="tooltip"
                            class="btn btn-default cms-btn">
                                <font-awesome-layers size="1x" style="background:MistyRose">
                                    <font-awesome-icon icon="circle" style="color:Tomato"/>
                                    <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                                </font-awesome-layers>
                        </button>
                    </td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td class="text-right">
                        <btn-add-setting :module-key="lists.key"></btn-add-setting>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>    
</template>

<script>
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';
    import BtnAddSetting from '../Btn/BtnAddSetting';

    export default {
        name: 'TheInfoList',
        components: {
            BtnAddSetting,
        },

        props: {
            lists: {
                default: {}
            }
        },

        computed: {
        },

        methods: {
            _getImgUrl() {
                return fn_get_base_url_image();

            },
            _addImage() {
                alert('add ok')
            }
        },

        setting: {
            image_title: 'Hình',
            image_capture_title: 'Tiêu đề',
            image_sort_order_title: 'Sắp xếp',
            
            image_action_title: 'Thực hiện',
            btn_image_sub_remove_txt: 'Xóa',
            btn_image_sub_add_txt: 'Thêm hình ảnh'
        }
    };
</script>
