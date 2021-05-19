<template>
    <b-carousel
        id="carousel-1"
        :interval="4000"
        controls
        indicators
    >
        <b-carousel-slide
            :img-src="item.imgUrl"
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
        mapActions
    } from 'vuex';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';
    import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_LASTED_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';

    import IconBook from 'v@front/assets/img/icon-book.png';

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
            //this.[GET_LASTED_INFORMATION_LIST_TO_CATEGORY](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_LASTED_INFORMATION_LIST_TO_CATEGORY
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
