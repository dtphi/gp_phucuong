<template>
    <form class="form-horizontal">
      <loading-over-lay 
        :active.sync="loading" 
        :is-full-page="fullPage"></loading-over-lay>
        <ul class="nav nav-tabs">
            
            <li>
                <a href="#tab-link" data-toggle="tab">{{$options.setting.tab_link_title}}</a>
            </li>
            
        </ul>
        <div class="tab-content">

            <div class="tab-pane active" id="tab-link">
                <tab-link
                        role="tabpanel"
                        class="tab-pane active"
                        :is-form="$options.setting.isForm"
                        :group-data="info"></tab-link>
            </div>

        </div>
    </form>
</template>

<script>
    import { EventBus } from '@app/api/utils/event-bus';
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_INFO_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_SET_LOADING,
    } from 'store@admin/types/action-types';
    import TabLink from './TabLink';

    export default {
        name: 'FormAdd',
        components: {
            TabLink,
        },
        data() {
            return {
                fullPage: false,
                file: null
            };
        },
        computed: {
            ...mapState(MODULE_INFO_ADD, {
                loading: state => state.loading
            }),

            ...mapGetters(MODULE_INFO_ADD, [
                'info',
            ])
        },

        methods: {
            ...mapActions(MODULE_INFO_ADD, [
                ACTION_SET_LOADING,
            ]),

            _submitInfo() {
                //this.[ACTION_INSERT_INFO](this.info);
            },
        },
        setting: {
            tab_general_title: 'Tổng quan',
            tab_advance_title: 'Mở rộng',
            tab_link_title: 'Danh sách',
            tab_design_title: 'Màn hình',
            error_msg_system: 'Lỗi hệ thống !',
        }
    };
</script>
