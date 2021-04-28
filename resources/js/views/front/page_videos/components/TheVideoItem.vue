<template>
    <figure>
        <a class="img-video" :href="_getHref()">
            <img :src="info.imgUrl" class="rounded img" :alt="_getHref()">
        </a>
        <figcaption class="figure-caption">
            <h4 class="title mt-2">
                <img :src="iconBook" alt="Icon">
                {{info.sort_name}}...
            </h4>
            <span class="d-block mb-1">{{info.sort_description.substring( 0, 100 )}}
                <a :href="_getHref()" >...</a></span>
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
import IconBook from 'v@front/assets/img/icon-book.png';

    export default {
        name: 'TheVideoItem',
        props: {
            info: {}
        },
        components: {
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
                    return fn_get_href_base_url('video/chi-tiet/'+this.info.name_slug);
                } else {
                    return fn_get_href_base_url('video/chi-tiet/' + fn_change_to_slug(this.info.name));
                }
            }
        }
    }
</script>
