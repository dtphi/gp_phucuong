<template>
    <b-col class="col-mobile" cols="3">
        <aside>
            <slot></slot>
            <info-left-side-bar></info-left-side-bar>
            <module-category-menu-left></module-category-menu-left>
            <newsletter-register class="form"></newsletter-register>
            <summary-contact class="logo"></summary-contact>
        </aside>
    </b-col>
</template>

<script>
    import InfoLeftSideBar from '../SideBar/SideBarInfoLeft';
    import ModuleCategoryMenuLeft from 'v@front/modules/category_left_side_bars';
    import NewsletterRegister from 'com@front/Common/NewsletterRegister';
    import SideBar from 'com@front/SideBar';
    import SummaryContact from 'com@front/SummaryContact';

    export default {
        name: 'ColumnLeft',
        components: {
            SideBar,
            InfoLeftSideBar,
            ModuleCategoryMenuLeft,
            NewsletterRegister,
            SummaryContact
        },
        data() {
            return {}
        },
    }
</script>

<style lang="scss">
    @import './left-column-styles.scss';
</style>
