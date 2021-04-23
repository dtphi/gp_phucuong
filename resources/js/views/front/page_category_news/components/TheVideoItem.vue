<template>
    <figure>
        <img :src="info.image" class="rounded img" alt="Giáo Phận Phú Cường">
        <figcaption class="figure-caption">
            <h4 class="title mt-2">
                <img src="../../../../views/front/assets/img/icon-book.png" alt="Icon">
                {{info.name}}
            </h4>
            <span class="d-block mb-1">{{info.sort_description.substring( 0, 100 )}}<a href="#">...</a></span>
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

    export default {
        name: 'VideoItem',
        props: {
            info: {}
        },
        components: {
        },
        data() {
            return {

            }
        },
    }
</script>
