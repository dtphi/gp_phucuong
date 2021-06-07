<template>
        <ul class="menu">
            <li class="active">
                <a href="/danh-muc-tin">📃 Tất cả</a>
            </li>
            <li>
                <a href="/tin-tuc/xem-nhieu">📃 Xem nhiều</a>
            </li>
            <li>
                <a href="http://www.sachnoiconggiao.com/" target="_blank">📃 Audio/Podcast</a>
            </li>
            <li>
                <a href="/video">📃 Video</a>
            </li>
            <hr class="border my-3">
        </ul>
</template>

<script>
	import{
      mapGetters,
      mapActions
  } from 'vuex';

    export default {
        name: 'InfoLeftSideBar',
        components: {
        },
        data() {
            return {

            }
        },
    }
</script>
