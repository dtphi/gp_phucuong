<template>
    <div class="table-responsive">
        <table id="images" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">{{$options.setting.image_sub_txt}}</td>
                    <td class="text-left">{{$options.setting.image_sub_sort_order_txt}}</td>
                    <td class="text-right">{{$options.setting.image_sub_action_txt}}</td>
                </tr>
            </thead>
            <tbody>
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
                    <td colspan="2"></td>
                    <td class="text-right">
                        <btn-add-image></btn-add-image>
                    </td>
                </tr>
            </tfoot>
        </table>

        <modal-form-add-image></modal-form-add-image>
    </div>    
</template>

<script>
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';
    import ModalFormAddImage from 'com@admin/Modal/Infos/FormAddImage';
    import BtnAddImage from '../Btn/BtnAddImage';

    export default {
        name: 'InfoImageForm',
        components: {
            ModalFormAddImage,
            BtnAddImage,
        },

        props: {
            infoImages: {
                default: []
            }
        },

        computed: {
        },

        methods: {
        },

        setting: {
            image_sub_txt: 'Hình ảnh bổ sung',
            image_sub_sort_order_txt: 'Sắp xếp',
            image_sub_action_txt: 'Thực hiện',
            btn_image_sub_remove_txt: 'Xóa',
            btn_image_sub_add_txt: 'Thêm hình ảnh'
        }
    };
</script>
