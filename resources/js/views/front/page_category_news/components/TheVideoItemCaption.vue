<template>
    <figcaption class="figure-caption">
        <h4 class="title mt-2 ellipsis-two-lines">
            <img
                :src="iconBook" alt="Icon">
            <a :href="_getHref()">{{info.sort_name}}...</a>
        </h4>
    </figcaption>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';
    import IconBook from 'v@front/assets/img/icon-book.png';

    export default {
        name: 'TheCategoryNewsItem',
        props: {
            info: {}
        },
        data() {
            return {
                iconBook: IconBook
            }
        },
        computed: {
            ...mapGetters(['iconBookUrl'])
        },
        methods: {
            _getHref() {
                if (this.info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('video/chi-tiet/' + this.info.name_slug);
                } else {
                    return fn_get_href_base_url('video/chi-tiet/' + fn_change_to_slug(this.info.name));
                }
            }
        }
    }
</script>
