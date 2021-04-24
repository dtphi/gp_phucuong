<template>
    <figure>
        <a :href="_getHref()">
            <img :src="info.image" class="rounded img" alt="Giáo Phận Phú Cường">
        </a>
        <figcaption class="figure-caption">
            <h4 class="title mt-2">
                <img src="../../../../views/front/assets/img/icon-book.png" alt="Icon">
                {{info.name}}
            </h4>
            <span class="d-block mb-1">{{info.sort_description.substring( 0, 100 )}}
                <a :href="_getHref()">...</a></span>
            <span class="d-block mb-1"></span>
            <span class="d-block">{{info.viewed}} lượt xem | 3 tháng trước</span>
        </figcaption>
    </figure>
</template>

<script>
	import{
      mapGetters,
      mapActions
  } from 'vuex';
  import {
    fn_get_href_base_url,
    fn_change_to_slug
} from '@app/api/utils/fn-helper';

    export default {
        name: 'TheCategoryNewsItem',
        props: {
            info: {}
        },
        components: {
        },
        data() {
            return {

            }
        },
        methods: {
            _getHref() {
                if (this.info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('tin-tuc-detail/'+this.info.name_slug);
                } else {
                    return fn_get_href_base_url('tin-tuc-detail/' + fn_change_to_slug(this.info.name));
                }
            }
        }
    }
</script>
