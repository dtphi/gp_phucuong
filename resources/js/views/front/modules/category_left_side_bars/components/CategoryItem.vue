<template>
    <li
        :class="_getActiveClass">
        <a
            @click="_getHref()">≫ {{_getTitle()}}</a>
    </li>
</template>

<script>
    import {
        mapActions,
        mapGetters,
        mapState
    } from 'vuex';
    import {
        MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR
    } from '@app/stores/front/types/module-types';

    export default {
        name: 'NavigationMainItem',
        props: {
            title: '',
            link: '',
            activeClass: '',
            group: {}
        },
        computed: {
            ...mapGetters([
                'moduleNameActive',
                'moduleActionListActive',
            ]),
            ...mapState(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR,[
                'linkActive'
            ]),
            _getActiveClass() {
                if (this.group.link == this.linkActive) {
                    return 'active';
                }

                return '';
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, [
                'setActiveLink'
            ]),
            _getTitle() {
                if (this.title) return this.title;

                return this.group.name;
            },
            _getHref() {
                const _self = this;
                const actionName = _self.moduleNameActive + '/' + _self.moduleActionListActive;
                _self.$store.dispatch(actionName, {
                    ...this.$route.params,
                    slug: _self.group.link,
                    moduleName: 'category_left_side_bar',
                    renderType: 1
                });
                this.setActiveLink(_self.group.link);
            }
        }
    }
</script>
