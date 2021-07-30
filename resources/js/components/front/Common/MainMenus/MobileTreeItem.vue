<template>
    <li>
        <mobile-collape-item
            @onTogleSubMenu="_togleSubMenu"
            v-if="level === 0"
            key="mobile-collape-menu"
            :is-folder="isFolder"
            :group="item"></mobile-collape-item>

        <mobile-nav-item
            v-else
            key="mobile-nav-menu"
            :group="item"></mobile-nav-item>

        <ul class="sub-menu pl-3"
            :class="togleClass"
            key="mobile-sub-tree-menu"
            v-if="isFolder">
            <mobile-nav-tree
                v-for="(child, index) in item.children"
                :level="_getLevel()"
                :key="index"
                :item="child"></mobile-nav-tree>
        </ul>
    </li>
</template>

<script>
    import MobileNavItem from './MobileItem';
    import MobileCollapeItem from './MobileCollapeItem';

    export default {
        name: 'MobileNavTree',
        components: {
            'MobileNavTree': this,
            'MobileNavItem': MobileNavItem,
            'MobileCollapeItem': MobileCollapeItem,
        },
        props: {
            level: {
                default: 0
            },
            isRoot: 0,
            item: [Object, Array]
        },
        data: function () {
            return {
                togleClass: ''
            };
        },
        computed: {
            isFolder() {
                return this.item.children && Object.keys(this.item.children).length;
            }
        },
        methods: {
            _getLevel() {
                return this.level + 1;
            },
            _togleSubMenu(togle) {
                if (togle === true) {
                    this.togleClass = this.$options.setting.togleClass;
                } else {
                    this.togleClass = '';
                }
            }
        },
        setting: {
            togleClass: 'cms-togle'
        }
    };
</script>
