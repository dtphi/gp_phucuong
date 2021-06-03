<template>
    <div id="van-kien-module" class="mt-4 new-document" v-if="pageLists.length">
        <h4 class="tit-common mb-3">📁 Văn kiện
            <a :href="_getHrefCate()" class="view-all">View all</a>
        </h4>
        <b-row>
            <b-col cols="4" class="col-mobile" 
                v-for="(item, index) in pageLists" 
                :key="index">
                <a class="d-block" :href="_getHref(item)">
                    <img class="img" :src="item.imgThumMediumImg" :alt="item.name">
                </a>
                <h4 class="tit-bg-common mt-2">
                    <a :href="_getHref(item)">{{item.name}}</a>
                </h4>
                <p class="info-post">
                    <b-icon class="alarm" icon="alarm"></b-icon>
                    <span>{{item.date_available}}</span>
                </p>
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
        MODULE_MODULE_VAN_KIEN
    } from 'store@front/types/module-types';
    import {
        ACTION_GET_SETTING
    } from 'store@front/types/action-types';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'ModuleVanKien',
        components: {},
        data() {
            return {
                fullPage: true,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_VAN_KIEN, [
                'settingCategory',
                'pageLists'
            ]),
            _isExist() {
                return this.settingCategory.length;
            }
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_VAN_KIEN, [
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
