<template>
    <li class="active">
    	<a href="#">{{title}}</a>
    </li>
</template>

<script>
    export default {
        name: 'NavigationMainItem',
        props: {
        	title: ''
        }
    }
</script>