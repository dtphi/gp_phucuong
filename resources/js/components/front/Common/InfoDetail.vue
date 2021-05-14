<template>
    <div class="new-detail">
        <h4 class="tit-detail">{{pageLists.name}}</h4>
        <p>
            <b-icon class="alarm" icon="alarm"></b-icon>
            <span>{{pageLists.date_available}}</span>
        </p>

        <p>{{pageLists.sort_description}}</p>

        <hr>

        <div class="text-detail" v-html="pageLists.description"></div>

        <hr>
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';
    import {
        MODULE_INFO_DETAIL
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';

    export default {
        name: 'ContentLeft',
        components: {
        },
        data() {
            return {
                imgFooter: ImgFooter
            }
        },
        computed: {
            ...mapGetters(MODULE_INFO_DETAIL, [
                'pageLists'
            ]),
        },
        methods: {
            ...mapActions(MODULE_INFO_DETAIL, [
                GET_DETAIL,
            ]),
        }
    }
</script>
