<template>
    <figure class="figure"
            @click="_redirectPage()">
        <img
            v-lazy="_getImgUrl()"
            class="rounded img" alt="Giáo Phận Phú Cường">
        <figcaption class="figure-caption"
                    @click="_redirectPage()">{{pageItem.title}}
        </figcaption>
    </figure>
</template>

<script>
    import {
        mapGetters
    } from 'vuex';
    import {
        fn_get_base_url
    } from '@app/api/utils/fn-helper'

    export default {
        name: 'TheItemPage',
        props: {
            pageItem: {},
            captionTitle: {
                default: '>>>>> Xem tin tức'
            }
        },
        data() {
            return {}
        },
        computed: {
            ...mapGetters(['bannerUrl'])
        },
        methods: {
            _redirectPage() {
                return window.location = this.pageItem.url;
            },
            _getImgUrl() {
                if (this.pageItem.imgThumbUrl) {
                    return this.pageItem.imgThumbUrl;
                }
                return fn_get_base_url() + this.pageItem.img;
            }
        }
    }
</script>
