<template>
    <div id="content-column-both">
        <keep-alive v-for="(item,idx) in _moduleList"  :key="idx">
            <component  v-bind:is="item"></component>
        </keep-alive>
    </div>
</template>

<script>
    import {
        mapState
    } from 'vuex';

    export default {
        name: 'ColumnBoth',
        components: {
            'module-noi-bat': () => import('v@front/modules/noi_bats'),
            'module-page-banner-list': () => import('v@front/modules/page_banner_lists'),
        },
        props: {
            contentType: {
                default: 'top'
            }
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
                    let modules = this.$route.meta.layout_content[contentType].both_modules;
                    if (modules && modules.length) {
                        
                        _.forEach(modules, function(item){
                            list.push("module-" + item.moduleName.toLowerCase());
                        });
                    }
                }

                return list;
            },
        }
    }
</script>
