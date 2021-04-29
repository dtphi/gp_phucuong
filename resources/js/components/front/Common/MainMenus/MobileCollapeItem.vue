<template>
    <li :class="activeClass">
    	<a v-if="isFolder" :href="_getHref()">{{_getTitle()}}</a>
        <a v-else :href="_getHref()">{{_getTitle()}}<label> > </label></a>
        <b-icon class="icon-plus" icon="plus"></b-icon>
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
        methods: {
        	_getTitle() {
        		if (this.title) return this.title;

        		return this.group.name;
        	},
            _getHref() {
                if (this.link) return fn_get_href_base_url(this.link);

                return fn_get_href_base_url('danh-muc-tin/'+this.group.link);
            }
        }
    }
</script>