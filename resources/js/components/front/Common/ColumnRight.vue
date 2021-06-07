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

    export default {
        name: 'ContentColumnRight',
        props: {
            contentType: {
                default: 'top'
            }
        },
        components: {
            'module-category-icon-side-bar': () => import('v@front/modules/category_icon_side_bars'),
            'module-thong-bao': () => import('v@front/modules/thong_baos'),
            'module-lich-cong-giao': () => import('v@front/modules/lich_cong_giaos'),
            'module-info-fanpage': () => import('v@front/modules/info_fanpages'),
            'module-youtube-hanh-cac-thanh': () => import('v@front/modules/youtube_hanh_cac_thanhs'),
            'module-sach-noi-iframe': () => import('v@front/modules/sach_noi_iframes'),
        },
        data() {
            return {
            }
        },
        computed: {
            _moduleList() {
                let list = [];
                let contentType = 'content_' + this.contentType + '_column';
                let modules = this.$route.meta.layout_content[contentType].right_modules;
                if (modules && modules.length) {
                    
                    _.forEach(modules, function(item){
                        list.push("module-" + item.moduleName.toLowerCase());
                    });
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
