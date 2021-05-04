<template>
    <div id="special-module">
        <h4 class="tit-highlights"><span>Nổi bật</span></h4>
        <b-row>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Sách nói</h4>
                <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                    <span>Chí khí - đường hi vọng</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Thanh Thúy</i>
                    </span>
                </a>
            </b-col>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Youtube</h4>
                <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                    <span>Chí khí - đường hi vọng</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Thanh Thúy</i>
                    </span>
                </a>
            </b-col>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Hát thanh vịnh</h4>
                <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                    <span>Chí khí - đường hi vọng</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Thanh Thúy</i>
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

    export default {
        name: 'ModuleNoiBat',
        components: {
        },
        data() {
            return {
                fullPage: true,

                iconBook: IconBook,
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

<style lang="scss">
    @import './styles.scss'
</style>