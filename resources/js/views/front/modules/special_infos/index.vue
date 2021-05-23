<template>
    <b-carousel
        id="carousel-1"
        :interval="4000"
        controls
        indicators
    >
        <b-carousel-slide
            :img-src="item.imgCarThumUrl"
            v-for="(item, index) in _getInfoCarousel" :key="index">
            <div class="description text-left">
                <h4>{{item.sort_name}}</h4>
                <p class="mb-2">
                    {{item.sort_description}}
                    <a :href="_getHref(item)" class="ml-2"><b>Xem thêm</b></a>
                </p>
                <p class="text-right mb-0">{{item.date_available}}</p>
            </div>
        </b-carousel-slide>
    </b-carousel>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_INFO,
        MODULE_MODULE_SPECIAL_INFO
    } from 'store@front/types/module-types';
    import {
        ACTION_GET_SETTING,
        GET_LASTED_INFORMATION_LIST_TO_CATEGORY
    } from 'store@front/types/action-types';
    import IconBook from 'v@front/assets/img/icon-book.png';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'ModuleCarouselInfo',
        components: {},
        data() {
            return {
                fullPage: true,
                iconBook: IconBook,
            }
        },
        computed: {
            ...mapState(MODULE_INFO, {
                infoList: state => state.infoLastedList
            }),
            ...mapGetters(MODULE_MODULE_SPECIAL_INFO, [
                'settingSpecialInfo',
                'pageLists'
            ]),
            _isExist() {
                return this.settingSpecialInfo.length;
            },
            _getInfoCarousel() {
                let lists = [];
                _.forEach(this.infoList, function(item, index) {
                    if (index < 5) {
                        lists.push(item)
                    }
                });

                return lists;
            }
        },
        created() {
            this.[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_LASTED_INFORMATION_LIST_TO_CATEGORY
            ]),
            ...mapActions(MODULE_MODULE_SPECIAL_INFO, [
                ACTION_GET_SETTING,
            ]),
            _getHref(info) {
                if (info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + info.name_slug);
                } else {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + fn_change_to_slug(info.name));
                }
            }
        }
    };
</script>
