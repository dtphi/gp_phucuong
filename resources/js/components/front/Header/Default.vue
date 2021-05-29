<template>
    <header id="header">
        <div class="header-news">
            <div class="container">
                <div class="breaking-news d-inline-block" style="text-align: right;">
                    <h4 class="title-breaking-news d-inline-block"></h4>
                    <p class="txt-breaking-news d-inline-block" >Truyền Thông và Lòng Thương Xót: Một cuộc gặp gỡ đem lại hoa trái</p>
                </div>
                <div class="subscribe d-inline-block">
                    <button class="btn">0274.73077088</button>
                </div>
            </div>
        </div>
        <banner></banner>
    </header>
</template>

<script>
	import Banner from './Default/Banner';

  export default {
      name: 'DefaultHeader',
      components: {Banner}
  };
</script>

<style lang="scss">
    @import './default-style.scss';
</style>