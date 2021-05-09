<template>
    <div id="category-left-side-bar-module">
        <ul class="menu">
            <category-item 
                v-for="(item, idx) in settingCategory" 
                :key="idx"
                :group="item"></category-item>
            <!--<li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Thánh ca</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Lời chúa</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Kinh thánh</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Thời sự</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Tiếng việt</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Bé kể bé nghe</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Giáo lý</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Chuyên đề</a></li>
            <li><a href="#"><img src="../../assets/img/icon-book.png" alt="Icon">Karaoke</a></li>-->
        </ul>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR
    } from '@app/stores/front/types/module-types';

    import {
        ACTION_GET_SETTING,
    } from '@app/stores/front/types/action-types';
    import CategoryItem from './components/CategoryItem';

    export default {
        name: 'ModuleCategoryMenuLeft',
        components: {
            CategoryItem
        },
        data() {
            return {
                fullPage: true
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, [
                'settingCategory',
            ])
        },

        created() {
            this.[ACTION_GET_SETTING]();
        },
        
        methods: {
             ...mapActions(MODULE_MODULE_CATEGORY_LEFT_SIDE_BAR, [
                ACTION_GET_SETTING,
            ]),
        },
        setting: {
            panel_title: 'Module Danh Mục Icon',
            frm_title: 'Thêm danh mục Icon',
            btn_save_txt: 'Lưu',
        }
    };
</script>

<style lang="scss">
    @import './styles.scss'
</style>