<template>
    <header id="header">
        <div class="header-news">
            <div class="container">
                <div class="breaking-news d-inline-block">
                    <h4 class="title-breaking-news d-inline-block">breaking news:</h4>
                    <p class="txt-breaking-news d-inline-block">Thứ 4 tuần V thường niên C - GKCĐ Giáo phận Phú Cường</p>
                </div>
                <div class="subscribe d-inline-block">
                    <button class="btn">subscribe</button>
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