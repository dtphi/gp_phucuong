<template>
    <div class="row mb-3 pb-3 row-item-app">
        <div class="col-4 col-img pl-0">
            <img class="img" v-lazy="_getImgUrl()" alt="Hình ảnh Phú Cường">
        </div>
        <div class="col-8 col-detail pl-0">
            <h4 class="tit-app-ft mt-2">{{appItem.title}}</h4>
            <a class="link-app d-block mb-2" :href="appItem.hrefAppStore" target="_blank">- Download từ Apple Store</a>
            <a class="link-app d-block" :href="appItem.hrefChPlay" target="_blank">- Download từ CH Play</a>
        </div>
    </div>
</template>

<script>
import {
        fn_get_base_url
    } from '@app/api/utils/fn-helper'

    export default {
        name: 'BlockAppFooter',
        components: {
        },
        props: {
            appItem: {}
        },
        data() {
        	return {
        		imageAppDefault: ''
        	}
        },
        methods: {
            _getImgUrl() {
                return fn_get_base_url() + this.appItem.img;
            }
        }
    };
</script>
