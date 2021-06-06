<template>
        <ul class="menu">
            <li class="active"><a href="/danh-muc-tin"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Tất cả</a></li>
            <li><a href="/tin-tuc/xem-nhieu"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Xem nhiều</a></li>
            <li><a href="/"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Đã xem</a></li>
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
