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
    import Navbar from '../../../components/admin/Navbar';
    import Sidebar from '../../../components/admin/Sidebar';
    import Footer from '../../../components/admin/Footer';
    import ControlSideBar from '../../../components/admin/Sidebar/ControlSideBar';

    export default {
        name: 'MainLayout',
        components: {Navbar, Sidebar, Footer, ControlSideBar}
    };
</script>