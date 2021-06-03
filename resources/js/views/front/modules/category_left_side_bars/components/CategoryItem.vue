<template>
    <li
        :class="activeClass">
        <a
            @click="_getHref()">
            <img src="../../../assets/img/icon-book.png" alt="Icon">{{_getTitle()}}</a>
    </li>
</template>

<script>
    import {
        mapGetters
    } from 'vuex';
    import {
        fn_get_href_base_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'NavigationMainItem',
        props: {
            title: '',
            link: '',
            activeClass: '',
            group: {}
        },
        computed: {
            ...mapGetters([
                'moduleNameActive',
                'moduleActionListActive'
            ]),
        },
        methods: {
            _getTitle() {
                if (this.title) return this.title;

                return this.group.name;
            },
            _getHref() {
                const _self = this;
                const actionName = _self.moduleNameActive + '/' + _self.moduleActionListActive;
                _self.$store.dispatch(actionName, {
                    ...this.$route.params,
                    slug: _self.group.link
                });
            }
        }
    }
</script>
