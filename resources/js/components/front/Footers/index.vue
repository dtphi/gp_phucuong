<template>
    <div id="footer">
        <div class="top-footer py-4">
            <div class="container">
                <div class="row">
                    <summary-contact class="col-3 text-center col-info"></summary-contact>
                    
                    <div class="col-5">
                        <h4 class="tit-ft mb-3">Ứng dụng</h4>
                        <block-app v-for="(item, idx) in appLists" :app-item="item" :key="idx"></block-app>
                    </div>

                    <registry-letter class="col-4"></registry-letter>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <copy-right></copy-right>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters
    } from 'vuex';
    import CopyRight from '../CopyRight';
    import BlockApp from './BlockApp';
    import RegistryLetter from '../RegistryLetter';
    import SummaryContact from '../SummaryContact';

    export default {
        name: 'MainFooter',
        components: {
            SummaryContact,
            BlockApp,
            RegistryLetter,
            CopyRight
        },
        computed: {
            ...mapGetters(['appLists']),
        }
    };
</script>

<style lang="scss">
    @import './footer-style.scss';
</style>