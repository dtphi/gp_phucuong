<template>
    <div class="row mb-3 pb-3 row-item-app">
        <div class="col-4 col-img pl-0">
            <img class="img" :src="imageAppDefault" alt="Hình ảnh Phú Cường">
        </div>
        <div class="col-8 col-detail pl-0">
            <h4 class="tit-app-ft mt-2">App sách nói công giáo</h4>
            <a class="link-app d-block mb-2" href="#">- Download từ Apple Store</a>
            <a class="link-app d-block" href="#">- Download từ CH Play</a>
        </div>
    </div>
</template>

<script>
	import imageApp from "v@front/assets/img/image_footer.jpg";

    export default {
        name: 'BlockAppFooter',
        components: {
        },
        data() {
        	return {
        		imageAppDefault: imageApp
        	}
        }
    };
</script>
