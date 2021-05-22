<template>
    <div class="table-responsive">
        <table id="info-list" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">{{$options.setting.info_title}}</td>
                    <td class="text-left">{{$options.setting.info_url_title}}</td>
                    <td class="text-left">{{$options.setting.info_author_titile}}</td>
                    <td class="text-left">{{$options.setting.info_sort_order_title}}</td>
                    <td calss="text-right">{{$options.setting.info_action_title}}</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, idx) in lists.value" :key="idx">
                    <td>
                        <input v-model="item.title" class="form-control" type="text"/>
                    </td>
                    <td>
                        <input v-model="item.url_title" class="form-control" type="text"/>
                    </td>
                    <td>
                        <input v-model="item.author" class="form-control" type="text"/>
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
                <!-- <tr id="image-row">
                    <td class="text-left">
                        <div class="file animated fadeIn" style="height: 61px">
                            <div class="file-preview">
                                <img :src="_getImgUrl()" class="thumb" />
                            </div>
                        </div>
                        <input type="hidden" name="news_image[]"
                               value="/"
                               id="input-image"/>
                    </td>
                    <td class="text-left">
                        <input type="text"
                          name="news_image[][sort_order]"
                          value="0"
                          :placeholder="$options.setting.image_sub_sort_order_txt"
                          class="form-control"/>
                    </td>
                    <td class="text-right">
                        <button type="button" onclick="$('#image-row').remove();"
                                data-toggle="tooltip" :title="$options.setting.btn_image_sub_remove_txt"
                                class="btn btn-default cms-btn">

                            <font-awesome-layers size="1x" style="background:MistyRose">
                                <font-awesome-icon icon="circle" style="color:Tomato"/>
                                <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                            </font-awesome-layers>
                        </button>
                    </td>
                </tr> -->
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4"></td>
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
