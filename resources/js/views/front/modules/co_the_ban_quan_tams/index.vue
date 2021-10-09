<template>
    <div id="co-the-ban-quan-tam-module" class="mt-2 mb-3 new-care">
        <h4 class="tit-common clr-blue mb-3">Có thể bạn quan tâm</h4>
        <div class="list-new">
            <a class="d-block mb-2" :href="_getHref(item)" v-for="(item, index) in _getInfoCarousel" :key="index">
                <span><b-icon class="arrow-right-circle-fill" icon="arrow-right-circle-fill"></b-icon></span>
                <span class="mr-2">{{item.description}}</span>
                <p><b-icon class="alarm" icon="alarm"></b-icon> {{item.date_available}}</p>
            </a>
        </div>
    </div>
</template>

<script>
    import{
        mapState,
        mapActions
    } from 'vuex';
    import {
        fn_get_href_base_url,
        fn_change_to_slug
    } from '@app/api/utils/fn-helper';

    import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';

    export default {
        name: 'ModuleThongBao',
        components: {},
        data() {
            return {
                fullPage: true,
            }
        },
        computed: {
            ...mapState(MODULE_INFO,{
                infoList: state => state.infoPopularList
            }),
            _getInfoCarousel() {
                let lists = [];
                _.forEach(this.infoList, function(item, index) {
                    if (index < 10) {
                        lists.push(item)
                    }
                });

                return lists;
            }
        },
        methods: {
            _getHref(info) {
                if (info.hasOwnProperty('name_slug')) {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + info.name_slug);
                } else {
                    return fn_get_href_base_url('tin-tuc/chi-tiet/' + fn_change_to_slug(info.name));
                }
            }
        },
        setting: {
            panel_title: 'Module Danh Mục Icon',
        }
    };
</script>
