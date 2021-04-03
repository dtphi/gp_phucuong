<template>
    <aside>
        <ul class="menu">
            <li class="active"><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Tất cả</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Xem nhiều</a></li>
            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Đã xem</a></li>
            <hr class="border my-3">
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

        <div class="form">
            <p class="font-weight-bold txt">Đăng ký để nhận tin mỗi ngày</p>
            <div class="input">
                <input class="d-block mb-3" type="email" name="email" id="email" placeholder="Enter your e-mail address">
                <input class="btn" type="button" value="Subscribe">
            </div>
        </div>

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

    export default {
        name: 'SideBar',
        components: {
        },
        data() {
            return {

            }
        },
    }
</script>
