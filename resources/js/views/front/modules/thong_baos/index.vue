<template>
    <div id="thong-bao-module" class="info mt-4" v-if="pageLists.length">
        <h4 class="tit-common clr-orange">📢 {{$options.setting.module_title}}</h4>
            <a 
                :href="_getHref(item)" 
                class="row-item-3 d-block mb-2 pb-2" 
                v-for="(item, index) in pageLists" 
                :key="index">
                <span>
                    <i class="status bg-green">Live</i>
                </span>
                <span>{{item.sort_name.substring( 0, 40 )}} …</span>
                <span>Admin</span>
            </a>
    </div>
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
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'ModuleThongBao',
        components: {},
        data() {
            return {
                fullPage: true,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_THONG_BAO, [
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
            ...mapActions(MODULE_MODULE_THONG_BAO, [
                ACTION_GET_SETTING,
            ]),
            _getHref(info) {
                if (info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + info.name_slug);
                } else {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + fn_change_to_slug(info.name));
                }
            }
        },
        setting: {
            module_title: 'Thông báo'
        }
    };
</script>

<style lang="scss">
    @import './styles.scss';
</style>
