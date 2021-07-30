<template>
    <li
        :class="activeClass">
        <div
            v-if="isFolder"
            key="mobile-menu-icon-plus">
            <a
                :href="_getHref()">{{_getTitle()}}</a>
            <b-icon
                class="icon-menu icon-plus" icon="plus"
                @click="_togleMenu"></b-icon>
        </div>
        <div 
            v-else
            key="mobile-menu-icon-caret">
        >
            <a
                :href="_getHref()">{{_getTitle()}}</a>
            <b-icon 
                class="icon-menu icon-caret" 
                icon="caret-right-fill"></b-icon>
        </div>
        <slot></slot>
    </li>
</template>

<script>
    import {
        fn_get_href_base_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'MobileNavigationMainCollapeItem',
        props: {
            isFolder: {
                default: 0
            },
            title: '',
            link: '',
            activeClass: '',
            group: {}
        },
        data() {
            return {
                togle: false,
            }
        },
        methods: {
            _getTitle() {
                if (this.title) return this.title;

                return this.group.name;
            },
            _getHref() {
                if (this.link) return fn_get_href_base_url(this.link);

                return fn_get_href_base_url('danh-muc-tin/' + this.group.link);
            },
            _togleMenu() {
                this.togle = !this.togle;
                this.$emit('onTogleSubMenu', this.togle);
            }
        }
    }
</script>
