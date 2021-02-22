<template>
    <div class="wrapper">
        <navbar></navbar>
        <sidebar></sidebar>
        <slot></slot>
        <footer></footer>
        <control-side-bar></control-side-bar>
    </div>
</template>

<script>
    import Navbar from 'com@admin/Navbar';
    import Sidebar from 'com@admin/Sidebar';
    import Footer from 'com@admin/Footer';
    import ControlSideBar from 'com@admin/Sidebar/ControlSideBar';

    export default {
        name: 'MainLayout',
        components: {
            Navbar,
            Sidebar,
            Footer,
            ControlSideBar
        }
    };
</script>
