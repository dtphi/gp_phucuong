<template>
    <form class="form-horizontal">
      <loading-over-lay 
        :active.sync="loading" 
        :is-full-page="fullPage"></loading-over-lay>
      <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab-general" data-toggle="tab">Tổng quan</a>
        </li>
        <li>
            <a href="#tab-advance" data-toggle="tab">Mở rộng</a>
        </li>
        <li>
            <a href="#tab-media-manager" data-toggle="tab">Hình ảnh</a>
        </li>
      </ul>
      <div class="tab-content">

        <div class="tab-pane active" id="tab-general">
            <tab-general
                    role="tabpanel"
                    class="tab-pane active"
                    :general-data="info"></tab-general>
        </div>

        <div class="tab-pane" id="tab-advance">
            <tab-advance
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"></tab-advance>
        </div>

        <div class="tab-pane" id="tab-media-manager">
            <tab-media-manager ref="mediaManagerTab"
                    role="tabpanel"
                    class="tab-pane"
                    :group-data="info"
                    :config-form="$options.setting"></tab-media-manager>
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
        ACTION_INSERT_INFO
    } from 'store@admin/types/action-types';
    import TabGeneral from './TabGeneral';
    import TabSetting from './TabSetting';
    import TabAdvance from './TabAdvance';
    import TabMediaManager from './TabImage';
    import {
        fn_redirect_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'ModalAddForm',
        components: {
            TabGeneral,
            TabAdvance,
            TabMediaManager,
            TabSetting
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

        mounted() {
            const _self = this;

            EventBus.$on('item-selected-group', (groupItem) => {
                if ((typeof groupItem === 'object') && groupItem.hasOwnProperty('id')) {
                    _self.info.newsgroup_id = groupItem.id;
                    _self.info.newsgroupname = groupItem.newsgroupname;
                }
                console.log(`Oh, that's nice. It's gotten ${groupItem.id} clicks! :)`)
            });

            EventBus.$on('on-selected-image', (imgItem) => {
                if (imgItem.selected) {
                    _self.info.picture = imgItem.selected.path;
                    _self.file = imgItem;
                } else {
                    _self.info.picture = null;
                }
            });
        },

        methods: {
            ...mapActions(MODULE_INFO_ADD, [
                ACTION_SET_LOADING,
                ACTION_INSERT_INFO
            ]),

            async _submitInfo() {
                const _self = this;
                _self.[ACTION_SET_LOADING](true);
                _self.$refs.observerInfo.validate().then((isValid) => {
                    if (isValid) {
                        _self.[ACTION_INSERT_INFO](_self.info)
                    } else {
                        _self.[ACTION_SET_LOADING](false)
                    }
                });
            },

            _back() {
                return fn_redirect_url('admin/news');
            }
        },
        setting: {
            btnCancelTxt: 'Back',
            nameTxt: 'Name',
            descriptionTxt: 'Description',
            newslinkTxt: 'News Link',
            actionName: 'add',
            isAddFrom: true,
            title: 'Add News',
            btnSubmitTxt: 'Save',
        }
    };
</script>
