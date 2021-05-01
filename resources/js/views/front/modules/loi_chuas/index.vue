<template>
    <div class="say-gods">
        <h4 class="tit-common mb-3"><img :src="iconBook" alt=""> Lời chúa</h4>
        <b-row>
            <b-col cols="5" class="col-mobile">
                <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                <h4 class="tit-bg-common mt-2">
                    <span><i class="bg-red">Nổi bật</i></span>
                    <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                </h4>
                <p><em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa</em></p>
                <p class="info-post text-right">
                    <img :src="iconBook" alt="">
                    <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                    <b-icon class="alarm" icon="alarm"></b-icon>
                    <span>12/03/2021</span>
                </p>
            </b-col>
            <b-col cols="7" class="col-mobile">
                <p class="info-post">
                    <span>13/2/2019</span>
                    <span class="name font-weight-bold ml-1">Giuse Quỳnh</span>
                </p>
                <h4 class="tit-bg-common">
                    <span><i class="bg-green">Mới</i></span>
                    <a href="#">Suy niệm chúa Nhật IV mùa chay B</a>
                </h4>
                <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                <p class="mb-2"><em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa...</em></p>
                <a class="font-weight-bold" href="#">Xem thêm</a>
                <hr>
                <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                    <span>
                        <i class="status bg-orange">Nổi bật</i>
                    </span>
                    <span>
                        Suy niệm chúa Nhật IV mùa chay B
                    </span>
                    <span class="text-right">
                        20/2/2021
                    </span>
                </a>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';

    import {
        MODULE_INFO_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_RESET_NOTIFICATION_INFO
    } from 'store@admin/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';

    export default {
        name: 'ModuleThongBao',
        components: {
        },
        data() {
            return {
                fullPage: true,

                iconBook: IconBook,
                imgFooter: ImgFooter
            }
        },
        
        methods: {
             
        },
        setting: {
            panel_title: 'Module Danh Mục Icon',
            frm_title: 'Thêm danh mục Icon',
            btn_save_txt: 'Lưu',
        }
    };
</script>
