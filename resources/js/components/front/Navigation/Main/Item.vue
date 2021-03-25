<template>
    <b-nav-item class="active">{{title}}</b-nav-item>
</template>

<script>
    export default {
        name: 'NavigationMainItem',
        props: {
        	title: ''
        }
    }
</script>