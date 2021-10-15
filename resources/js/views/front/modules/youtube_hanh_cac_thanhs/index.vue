<template>
    <div class="mt-4">
        <h4 class="tit-common clr-orange">Hạnh các thánh</h4>
        <div id="Hanhcacthanh-PlaylistYoutube" class="embed-responsive embed-responsive-4by3">
            <iframe allowfullscreen="" class="embed-responsive-item" frameborder="0" height="360"
                    src="https://www.youtube-nocookie.com/embed/videoseries?list=PL-uyh2tqni7nLxdHqWjTbLyIoJEriY7lM"
                    width="640"></iframe>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_THONG_BAO
    } from 'store@front/types/module-types';
    import {
        ACTION_GET_SETTING
    } from 'store@front/types/action-types';

    export default {
        name: 'ModuleHanhCacThanh',
        components: {},
        data() {
            return {
                fullPage: true,
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_THONG_BAO, [
                'settingCategory',
            ]),
            _isExist() {
                return this.settingCategory.length;
            }
        },
        created() {
            //this[ACTION_GET_SETTING]();
        },
        methods: {
            ...mapActions(MODULE_MODULE_THONG_BAO, [
                ACTION_GET_SETTING,
            ]),
        }
    };
</script>
