<template>
    <div class="wrapper">
        <Navbar />
        <Sidebar />
        <slot></slot>
        <Footer />
        <ControlSideBar />
    </div>
</template>

<script>
    import Navbar from 'com@admin/Navbar';
    import Sidebar from 'com@admin/Sidebar';
    import Footer from 'com@admin/Footer';
    import ControlSideBar from 'com@admin/Sidebar/ControlSideBar';

    export default {
        name: 'MainLayout',
        components: {Navbar, Sidebar, Footer, ControlSideBar}
    };
</script>