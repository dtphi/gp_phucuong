<template>
    <b-card no-body class="mt-3">
        <b-tabs card>
            <b-tab class="tab-bar" title="Bài mới" active>
                <b-card-text>
                    <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in infoList" :key="index">
                        <span>
                            <i class="status bg-blue">Live</i>
                        </span>
                        <span>
                            <img :src="iconBook" alt="">
                            <i>Điểm tin giáo hội</i>
                        </span>
                        <span>
                            <img :src="iconBook" alt="">
                            <i>Thanh Thúy</i>
                        </span>
                    </a>
                </b-card-text>
            </b-tab>
            <b-tab title="Xem nhiều">
                <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in infoList" :key="index">
                    <span>
                        <i class="status bg-orange">Hot</i>
                    </span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Điểm tin giáo hội</i>
                    </span>
                    <span>
                        <img :src="iconBook" alt="">
                        <i>Thanh Thúy</i>
                    </span>
                </a>
            </b-tab>
        </b-tabs>
    </b-card>
</template>

<script>
	import{
      mapState,
      mapActions
  } from 'vuex';

  import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL,
        GET_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';


    export default {
        name: 'TabInfoViewedAndPopular',
        components: {
        },
        data() {
            return {
                iconBook: IconBook
            }
        },
        computed: {
            ...mapState(MODULE_INFO,{
                infoList: state => state.pageLists
            }),
        },
        mounted() {
            this.[GET_INFORMATION_LIST_TO_CATEGORY](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_DETAIL,GET_INFORMATION_LIST_TO_CATEGORY
            ]),
        }
    }
</script>

<style lang="scss">
</style>