<template>
    <div id="tin_giao_phan_module" class="mt-4 new-diocese" v-if="pageLists.length">
        <h4 class="tit-common mb-3">
            <img :src="iconBook" alt=""> Tin giáo phận
            <a :href="_getHrefCate()" class="view-all">View all</a>
        </h4>
        <b-row>
            <b-col cols="7" class="col-mobile">
                <a class="d-block" href="#">
                    <img class="img" :src="_getLastedModuleInfo.imgThumUrl" alt=""></a>
                <h4 class="tit-bg-common mt-2">
                    <a :href="_getHref(_getLastedModuleInfo)">{{_getLastedModuleInfo.name}}</a>
                </h4>
                <p class="info-post">
                    <img :src="iconBook" alt="">
                    <span class="name font-weight-bold mr-1">Admin</span>
                    <b-icon class="alarm" icon="alarm"></b-icon>
                    <span>{{_getLastedModuleInfo.date_available}}</span>
                </p>
            </b-col>
            <b-col cols="5" class="col-r col-mobile">
                <div>
                    <a class="d-block" :href="_getHref(_getSecondInfoModuleList)">
                        <img class="img" :src="_getSecondInfoModuleList.imgThumUrl" alt="">
                    </a>
                    <h4 class="tit-bg-common mt-2">
                        <a :href="_getHref(_getSecondInfoModuleList)">{{_getSecondInfoModuleList.name}}</a>
                    </h4>
                    <p class="info-post">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Admin</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>{{_getSecondInfoModuleList.date_available}}</span>
                    </p>

                    <hr class="my-2">
                </div>
                <div 
                    v-for="(item, index) in _getInfoListModule" 
                    :key="index">
                    <h4 class="tit-bg-common">
                        <a href="#">{{item.name}}</a>
                    </h4>
                    <p class="info-post">
                        <img :src="iconBook" alt="">
                        <span class="name font-weight-bold mr-1">Admin</span>
                        <b-icon class="alarm" icon="alarm"></b-icon>
                        <span>{{item.date_available}}</span>
                    </p>

                    <hr class="my-2">
                </div>
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
        MODULE_MODULE_TIN_GIAO_PHAN
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
        name: 'ModuleTinGiaoPhan',
        components: {},
        data() {
            return {
                fullPage: true,
                iconBook: IconBook,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_TIN_GIAO_PHAN, [
                'settingCategory',
                'pageLists'
            ]),
            _isExist() {
                return this.settingCategory.length;
            },
            _getInfoListModule() {
                let lists = [];
                lists.push(this.pageLists[2]);
                lists.push(this.pageLists[3]);

                return lists;
            },
            _getLastedModuleInfo() {
                return this.pageLists[0];
            },
            _getSecondInfoModuleList() {
                return this.pageLists[1];
            }
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_TIN_GIAO_PHAN, [
                ACTION_GET_SETTING,
            ]),
            _getHref(info) {
                if (info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + info.name_slug);
                } else {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + fn_change_to_slug(info.name));
                }
            },
            _getHrefCate() {
                return fn_get_href_base_url('danh-muc-tin/' + this.settingCategory[0].link)
            }
        },
        setting: {
        }
    };
</script>
