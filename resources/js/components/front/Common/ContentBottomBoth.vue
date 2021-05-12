<template>
    <div id="content-bottom-both">
        <module-noi-bat></module-noi-bat>
    </div>
</template>

<script>
    import IconBook from 'v@front/assets/img/icon-book.png';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';
    import ModuleNoiBat from 'v@front/modules/noi_bats';

    export default {
        name: 'ContentBottomBoth',
        components: {
            ModuleNoiBat,
        },
        data() {
            return {
                iconBook: IconBook,
                imgFooter: ImgFooter
            }
        }
    }
</script>
