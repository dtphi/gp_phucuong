<template>
    <b-col cols="8" class="col-mobile">
        <module-loi-chua></module-loi-chua>

        <b-row class="mt-4">
            <b-col cols="6" class="col-mobile">
                <div class="new mt-3">
                    <h4 class="tit-common mb-3"><img :src="iconBook" alt=""> Tin giáo hội</h4>
                    <p class="info-post mb-2">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>12/03/2021</span>
                    </p>
                    <h4 class="tit-bg-common">
                        <span><i class="bg-orange">hot</i></span>
                        <a href="#">Chúc mừng Đức Tổng Giám Mục Leopoldo Girelli</a>
                    </h4>
                    <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                    <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                    
                    <p class="mt-2">
                        <em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa...</em>
                        <a class="font-weight-bold" href="#">Xem thêm</a>
                    </p>

                    <hr>

                    <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                        <span>
                            <i class="status bg-green">Live</i>
                        </span>
                        <span>
                            <img :src="iconBook" alt="">
                            <i>Điểm tin giáo hội</i>
                        </span>
                        <span>
                            <img :src="iconBook" alt="">
                            <i>Thanh Thúy</i>
                        </span>
                    </a>
                </div>
            </b-col>

            <b-col cols="6" class="col-mobile">
                <div class="new mt-3">
                    <h4 class="tit-common mb-3"><img :src="iconBook" alt=""> Tin giáo hội việt nam</h4>
                    <p class="info-post mb-2">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>12/03/2021</span>
                    </p>
                    <h4 class="tit-bg-common">
                        <span><i class="bg-green">live</i></span>
                        <a href="#">Chúc mừng Đức Tổng Giám Mục Leopoldo Girelli</a>
                    </h4>
                    <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                    <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                    
                    <p class="mt-2">
                        <em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa...</em>
                        <a class="font-weight-bold" href="#">Xem thêm</a>
                    </p>

                    <hr>
                    
                    <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                        <span>
                            <i class="status bg-red">hot</i>
                        </span>
                        <span>
                            <img :src="iconBook" alt="">
                            <i>Điểm tin giáo hội</i>
                        </span>
                        <span>
                            <img :src="iconBook" alt="">
                            <i>Thanh Thúy</i>
                        </span>
                    </a>
                </div>
            </b-col>
        </b-row>

        <div class="mt-4 new-diocese">
            <h4 class="tit-common mb-3">
                <img :src="iconBook" alt=""> Tin giáo phận
                <a href="#" class="view-all">View all</a>
            </h4>
            <b-row>
                <b-col cols="7" class="col-mobile">
                    <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                    <h4 class="tit-bg-common mt-2">
                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                    </h4>
                    <p class="info-post">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>12/03/2021</span>
                    </p>
                </b-col>
                <b-col cols="5" class="col-r col-mobile">
                    <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                    <h4 class="tit-bg-common mt-2">
                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                    </h4>
                    <p class="info-post">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>12/03/2021</span>
                    </p>

                    <hr class="my-2">

                    <h4 class="tit-bg-common">
                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                    </h4>
                    <p class="info-post">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>12/03/2021</span>
                    </p>

                    <hr class="my-2">

                    <h4 class="tit-bg-common">
                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                    </h4>
                    <p class="info-post">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>12/03/2021</span>
                    </p>
                </b-col>
            </b-row>
        </div>

        <div class="mt-4 new-document">
            <h4 class="tit-common mb-3">
                <img :src="iconBook" alt=""> Văn kiện
                <a href="#" class="view-all">View all</a>
            </h4>
            <b-row>
                <b-col cols="4" class="col-mobile" v-for="(item, index) in 3" :key="index">
                    <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                    <h4 class="tit-bg-common mt-2">
                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                    </h4>
                    <p class="info-post">
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>12/03/2021</span>
                    </p>
                </b-col>
            </b-row>
        </div>
    </b-col>
</template>

<script>
	import{
      mapState,
      mapActions
  } from 'vuex';

  import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL,
        GET_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';
    import ModuleLoiChua from 'v@front/modules/loi_chuas';

    export default {
        name: 'ContentBottomLeft',
        components: {
            ModuleLoiChua,
        },
        data() {
            return {
                iconBook: IconBook,
                imgFooter: ImgFooter
            }
        },
        computed: {
            ...mapState(MODULE_INFO,{
                infoList: state => state.pageLists
            }),
        },
        mounted() {
            this.[GET_INFORMATION_LIST_TO_CATEGORY](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_DETAIL,GET_INFORMATION_LIST_TO_CATEGORY
            ]),
        }
    }
</script>

<style lang="scss">
</style>