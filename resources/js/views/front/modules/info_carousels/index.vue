<template>
    <b-carousel
        id="carousel-1"
        :interval="4000"
        controls
        indicators
    >
        <b-carousel-slide
            img-src="https://giaophanphucuong.org/Image/Picture/Images/CacGiaoXu/HatPhuCuong/NhaThoChanhToa-Thuml.jpg"
            v-for="(link, index) in 3" :key="index">
            <div class="description text-left">
                <h4>Thông báo:</h4>
                <p class="mb-2">
                    Ban Truyền Thông Giáo Phận 104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương...
                    <a href="#" class="ml-2"><b>Xem thêm</b></a>
                </p>
                <p class="text-right mb-0">25/12/2021 Thanh Thúy</p>
            </div>
        </b-carousel-slide>
    </b-carousel>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_THONG_BAO
    } from 'store@front/types/module-types';
    import {
        ACTION_GET_SETTING
    } from 'store@front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';

    export default {
        name: 'ModuleCarouselInfo',
        components: {},
        data() {
            return {
                fullPage: true,
                iconBook: IconBook,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_THONG_BAO, [
                'settingCategory',
            ]),
            _isExist() {
                return this.settingCategory.length;
            }
        },
        created() {
            //this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_THONG_BAO, [
                ACTION_GET_SETTING,
            ]),
        }
    };
</script>
