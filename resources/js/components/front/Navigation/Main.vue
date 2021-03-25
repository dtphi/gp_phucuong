<template>
    <nav id="nav" class="mt-0">
        <b-nav>
            <nav-main-item title="Home"></nav-main-item>
            <b-nav-item>Tin giáo phận</b-nav-item>
            <b-nav-item>Giáo hội hoàn vũ</b-nav-item>
            <b-nav-item>Giáo hội việt nam</b-nav-item>
            <b-nav-item>Lời chúa</b-nav-item>
            <b-nav-item>Tài liệu</b-nav-item>
            <b-nav-item>Đáp ca</b-nav-item>
            <b-nav-item>Hôn nhân</b-nav-item>
            <b-nav-item>Tiếng việt</b-nav-item>
            <b-nav-item>Văn kiện</b-nav-item>
            <b-nav-item><b-icon icon="person-fill"></b-icon></b-nav-item>
            <b-nav-item><b-icon icon="search"></b-icon></b-nav-item>
        </b-nav>
    </nav>
</template>

<script>
	import NavMainItem from './Main/Item';

  export default {
      name: 'Navigation',
      components: {NavMainItem}
  }
</script>

<style lang="scss">
    @import './main-style.scss';
</style>