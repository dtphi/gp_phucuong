<template>
    <aside>
        <info-left-side-bar></info-left-side-bar>
        <ul class="menu">   
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Thánh ca</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Lời chúa</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Kinh thánh</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Thời sự</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Tiếng việt</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Bé kể bé nghe</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Giáo lý</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Chuyên đề</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Karaoke</a></li>
        </ul>

        <hr class="border my-3">

        <newsletter-register></newsletter-register>

        <hr class="border my-4">

        <div class="logo">
            <p class="mb-4"><img src="../../../views/front/assets/img/logo.png" alt="Logo Phú Cường"></p>
            <h4 class="title mb-3">Giáo Phận Phú Cường</h4>
            <p class="mb-0">Ban Truyền Thông Giáo Phận</p>
            <p>104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương</p>
            <p class="mb-0">+84 274 730 7788</p>
            <p class="mb-0">giaophanphucuong@gmail.com</p>
        </div>
    </aside>
</template>

<script>
	import{
      mapGetters,
      mapActions
  } from 'vuex';
  import InfoLeftSideBar from './SideBarInfoLeft';
  import NewsletterRegister from 'com@front/Common/NewsletterRegister';

    export default {
        name: 'SideBar',
        components: {
            InfoLeftSideBar,
            NewsletterRegister
        },
        data() {
            return {

            }
        },
    }
</script>
