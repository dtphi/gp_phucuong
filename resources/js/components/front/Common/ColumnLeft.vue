<template>
    <b-col class="col-mobile" cols="3">
        <aside>
            <slot></slot>
            <keep-alive v-for="(item,idx) in _moduleList"  :key="idx">
                <component  v-bind:is="item.name" :class="item.cCl"></component>
            </keep-alive>
        </aside>
    </b-col>
</template>

<script>

    export default {
        name: 'ColumnLeft',
        components: {
            'module-info-left-side-bar': () => import('../SideBar/SideBarInfoLeft'),
            'module-category-left-side-bar': () => import('v@front/modules/category_left_side_bars'),
            'module-newsletter-register': () => import('com@front/Common/NewsletterRegister'),
            'module-summary-contact': () => import('com@front/SummaryContact'),
        },
        props: {
            contentType: {
                default: 'top'
            }
        },
        data() {
            return {}
        },
        computed: {
            _moduleList() {
                let list = [];
                let contentType = 'content_' + this.contentType + '_column';
                let modules = this.$route.meta.layout_content[contentType].left_modules;
                if (modules && modules.length) {
                    
                    _.forEach(modules, function(item){
                        list.push({
                            name: "module-" + item.moduleName.toLowerCase(),
                            cCl: item.componentClass
                        });
                    });
                }

                return list;
            }
        }
    }
</script>

<style lang="scss">
    @import './left-column-styles.scss';
</style>
