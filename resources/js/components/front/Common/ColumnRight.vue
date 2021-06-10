<template>
    <b-col
        :cols="_getColumnNumber()"
        class="col-mobile">
        <slot></slot>

        <keep-alive v-for="(item,idx) in _moduleList"  :key="idx">
            <component  v-bind:is="item"></component>
        </keep-alive>
    </b-col>
</template>

<script>
    import {
        mapState
    } from 'vuex';
    import category_icon_side_bars from 'v@front/modules/category_icon_side_bars';
    import thong_baos from 'v@front/modules/thong_baos';
    import lich_cong_giaos from 'v@front/modules/lich_cong_giaos';
    import info_fanpages from 'v@front/modules/info_fanpages';
    import youtube_hanh_cac_thanhs from 'v@front/modules/youtube_hanh_cac_thanhs';
    import sach_noi_iframes from 'v@front/modules/sach_noi_iframes';

    export default {
        name: 'ContentColumnRight',
        props: {
            contentType: {
                default: 'top'
            }
        },
        components: {
            'module-category-icon-side-bar': category_icon_side_bars,
            'module-thong-bao': thong_baos,
            'module-lich-cong-giao': lich_cong_giaos,
            'module-info-fanpage': info_fanpages,
            'module-youtube-hanh-cac-thanh': youtube_hanh_cac_thanhs,
            'module-sach-noi-iframe': sach_noi_iframes,
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapState({
                setting: state => state.cfApp.setting
            }),
            _moduleList() {
                let list = [];

                if (Object.keys(this.setting) && this.setting.hasOwnProperty('modules')) {
                    let contentType = 'content_' + this.contentType + '_column';
                    let modules = this.$route.meta.layout_content[contentType].right_modules;
                    if (modules && modules.length) {
                        
                        _.forEach(modules, function(item){
                            list.push("module-" + item.moduleName.toLowerCase());
                        });
                    }
                }

                return list;
            }
        },
        methods: {
            _getColumnNumber() {
                let contentType = 'content_' + this.contentType + '_column';
                
                return this.$route.meta.layout_content[contentType].right_column;
            }
        }
    }
</script>
