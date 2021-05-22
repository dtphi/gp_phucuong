<template>
    <div id="special-module">
        <h4 class="tit-highlights"><span>Nổi bật</span></h4>
        <b-row>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Sách nói</h4>
                <a :href="item.url_title" class="row-item-2" v-for="(item, index) in settingSachNoi" :key="index">
                    <span>{{item.title}}</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>{{item.author}}</i>
                    </span>
                </a>
            </b-col>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Youtube</h4>
                <a :href="item.url_title"  class="row-item-2" v-for="(item, index) in settingYoutube" :key="index">
                    <span>{{item.title}}</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>{{item.author}}</i>
                    </span>
                </a>
            </b-col>
            <b-col cols="4" class="mb-3 col-mobile">
                <h4 class="tit-common">Hát thanh vịnh</h4>
                <a :href="item.url_title" class="row-item-2" v-for="(item, index) in settingHanhCacThanh" :key="index">
                    <span>{{item.title}}</span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>{{item.author}}</i>
                    </span>
                </a>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_NOI_BAT
    } from 'store@front/types/module-types';
    import {
        ACTION_GET_SETTING
    } from 'store@front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'ModuleNoiBat',
        data() {
            return {
                fullPage: true,
                iconBook: IconBook,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_NOI_BAT, [
                'settingSachNoi',
                'settingYoutube',
                'settingHanhCacThanh',
                'pageLists'
            ]),
            _isExist() {
                return this.settingSachNoi.length;
            }
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                ACTION_GET_SETTING,
            ])
        },
        setting: {
            panel_title: 'Module Danh Mục Icon',
            frm_title: 'Thêm danh mục Icon',
            btn_save_txt: 'Lưu',
        }
    };
</script>
