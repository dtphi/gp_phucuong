<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4">
        <!-- Brand Logo -->
        <a href="http://haydesachnoipodcast.com" class="brand-link">
            <logo class="brand-image"></logo>
            <span class="brand-text font-weight-bold">Giáo Phận</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-4">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <nav-link
                        label="Users"
                        link="/admin/users"
                        index="users"
                        iconName="user"
                        :active-item="activeItem"
                    />
                    <nav-link
                        label="News Groups"
                        link="/admin/news-groups"
                        index="news-groups"
                        iconName="folder"
                        :active-item="activeItem"
                    />
                    <nav-link
                        label="News"
                        link="/admin/news"
                        index="infomations"
                        iconName="info"
                        :active-item="activeItem"
                    />
                    <nav-link
                        label="News Files"
                        link="/admin/filemanagers"
                        index="filemanagers"
                        iconName="file"
                        :active-item="activeItem"
                    />

                    <logout v-if="authenticated"/>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import Logout from './Logout';
    import NavLink from './NavLink';
    import {
        MODULE_AUTH,
        MODULE_LAYOUT
    } from 'store@admin/types/module-types';
    import Logo from 'com@admin/Logo';

    export default {
        name: 'Sidebar',
        components: {
            Logo,
            Logout, 
            NavLink
        },
        computed: {
            ...mapGetters(MODULE_AUTH, ['authenticated']),
            ...mapState(MODULE_LAYOUT, {
                sidebarStatic: state => state.sidebarStatic,
                sidebarOpened: state => !state.sidebarClose,
                activeItem: state => state.sidebarActiveElement,
            }),
            ...mapState(['cfApp']),
        },
        methods: {
            ...mapActions(MODULE_LAYOUT, ['changeSidebarActive', 'switchSidebar']),
            setActiveByRoute() {
                const paths = this.$route.fullPath.split('/admin');
                var pathActive = paths.pop();

                if (pathActive === '/news') {
                    pathActive = '/infomations';
                }
                this.changeSidebarActive(pathActive);
            },
        },
        created() {
            this.setActiveByRoute();
        },
    };
</script>
