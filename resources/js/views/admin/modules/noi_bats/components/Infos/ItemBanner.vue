<template>
     <tr>
        <td class="text-left">
            <div class="file animated fadeIn" style="height: 61px">
                <div class="file-preview">
                    <img :src="_getImgUrl()" class="thumb"/>
                </div>
            </div>
        </td>
        <td>
            <input 
                v-model="banner.url_full" type="text" class="form-control" />
        </td>
        <td>
            <input 
                v-model="banner.width" type="text" class="form-control" />
        </td>
        <td>
            <input 
                v-model="banner.height" type="text" class="form-control" />
        </td>
    </tr>   
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        fn_get_base_url_image
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheItemBanner',
        props: {
            banner: {
                default: {}
            }
        },
        data() {
            return {
            }
        },
        computed: {
        },
        methods: {
            _getImgUrl() {console.log(this.banner)
                return '/Image/NewPicture/'+this.banner.image;
            }
        },
        setting: {
            image_title: 'Banner',
            image_url_title: 'Url hình'
        }
    };
</script>
