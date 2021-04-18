<template>
    <li :class="activeClass">
    	<a href="#">{{getTitle()}}</a>
    </li>
</template>

<script>
    export default {
        name: 'NavigationMainItem',
        props: {
        	title: '',
        	activeClass: '',
        	group: {}
        },
        methods: {
        	getTitle() {
        		if (this.title) return this.title;

        		return this.group.name;
        	}
        }
    }
</script>