<template>
    <div class="mt-4 new-related" v-if="infoRelateds.length">
        <h4 class="tit-common clr-blue mb-3">Tin liên quan</h4>
        <b-row>
            <b-col class="col-mobile" cols="4" v-for="(item, idx) in _getRelatedListInfo" :key="idx">
                <a class="d-block img-related" :href="_getHref(item)">
                    <img v-if="_innerScreen767" class="img" v-lazy="item.imgUrl" alt="">
                    <img v-else class="img" v-lazy="item.imgThumMediumImg" alt="">
                </a>
                <h4 class="tit-bg-common mt-2">
                    <a class="pl-0" :href="_getHref(item)">{{item.name}}</a>
                </h4>
                <p class="info-post">
                    <b-icon class="alarm" icon="alarm"></b-icon>
                    <span>{{item.date_available}}</span>
                </p>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {
        mapActions,
        mapGetters,
    } from 'vuex';
    import {
        MODULE_INFO_DETAIL
    } from '@app/stores/front/types/module-types';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheRelatedInfo',

        data() {
            return {}
        },
        computed: {
            ...mapGetters([
                'isScreen767'
            ]),
            ...mapGetters(MODULE_INFO_DETAIL, [
                'pageLists',
                'infoRelateds'
            ]),
            _getRelatedListInfo() {
                const _self = this;
                return _.filter(this.infoRelateds, function(o) { 
                    return o.information_id !== _self.pageLists.information_id; 
                });
            },
            _innerScreen767 () {
                return this.isScreen767;
            }
        },
        methods: {
            _getHref(info) {
                if (info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + info.name_slug);
                } else {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + fn_change_to_slug(info.name));
                }
            }
        },
    }
</script>

<style lang="scss">
    .new-related {
        .img-related {
            height: 230px;
        }
    }
</style>