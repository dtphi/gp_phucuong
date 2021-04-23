<template>
    <li :class="activeClass">
    	<a :href="_getHref()">{{_getTitle()}}</a>
    </li>
</template>

<script>
import {
    fn_get_href_base_url
} from '@app/api/utils/fn-helper';
    export default {
        name: 'NavigationMainItem',
        props: {
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
                if (this.link) return this.link;

                return fn_get_href_base_url('danh-muc-tin/'+this.group.link);
            }
        }
    }
</script>