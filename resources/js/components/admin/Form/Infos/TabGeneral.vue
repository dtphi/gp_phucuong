<template>
    <transition name="modal-tab-general">
        <div class="card-body">
            <div class="form-group row">
                <label for="news_name" class="col-sm-2 col-form-label">{{$options.setting.nameTxt}}</label>
                <div class="col-sm-10">
                    <validation-provider name="news_name" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="generalData.newsname" type="text" class="form-control"
                               :placeholder="$options.setting.nameTxt">
                        <span class="text-red">{{ errors[0] }}</span>
                    </validation-provider>
                </div>
            </div>
            <div class="form-group row">
                <label for="news_description"
                       class="col-sm-2 col-form-label">{{$options.setting.descriptionTxt}}</label>
                <div class="col-sm-10">
                    <validation-provider name="news_description" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="generalData.description" class="form-control"
                               :placeholder="$options.setting.descriptionTxt">
                        <span class="text-red">{{ errors[0] }}</span>
                    </validation-provider>
                </div>
            </div>
            <div class="form-group row">
                <label for="news_newslink" class="col-sm-2 col-form-label">{{$options.setting.newsLinkTxt}}</label>
                <div class="col-sm-10">
                    <validation-provider name="news_newslink" rules="required|max:191" v-slot="{ errors }">
                        <input v-model="generalData.newslink" class="form-control"
                               :placeholder="$options.setting.newsLinkTxt">
                        <span class="text-red">{{ errors[0] }}</span>
                    </validation-provider>
                </div>
            </div>
            <div class="form-group row">
                <label for="news-context" class="col-sm-2 col-form-label">{{$options.setting.newsContextTxt}}</label>
                <div class="col-sm-10">
                    <tinymce 
                        id="news-context" 
                        :other_options="options"
                        v-model="generalData.context"></tinymce>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_INFO_MODAL
    } from 'store@admin/types/module-types';
    import {
        ACTION_CLOSE_MODAL,
        ACTION_SET_LOADING,
        ACTION_INSERT_INFO,
        ACTION_UPDATE_INFO
    } from 'store@admin/types/action-types';
    import tinymce from 'vue-tinymce-editor';
    import {
        fn_get_tinymce_langs_url
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TabGeneralForm',
        components: { tinymce },
        props: {
            generalData: {
                type: Object
            }
        },
        data() {
            return {
                options: {
                    language_url: fn_get_tinymce_langs_url('vi_VN'),
                }
            };
        },

        watch: {
            generalData: {
                immediate: true,
                deep: true,
                handler(newValue, oldValue) {
                    if (Object.keys(newValue).length) {
                        return newValue.context = (newValue.context === null) ? "": newValue.context;
                    }
                }
            }
        },

        methods: {
            ...mapActions(MODULE_INFO_MODAL, [
                ACTION_CLOSE_MODAL,
                ACTION_SET_LOADING,
                ACTION_INSERT_INFO,
                ACTION_UPDATE_INFO
            ]),
        },
        setting: {
            btnCancelTxt: 'Close',
            nameTxt: 'Name',
            descriptionTxt: 'Description',
            newsLinkTxt: 'News Link',
            newsContextTxt: 'Content',
            add: {
                actionName: 'add',
                isAddFrom: true,
                title: 'Add News',
                btnSubmitTxt: 'Save'
            },
            edit: {
                actionName: 'edit',
                isAddFrom: false,
                title: 'Edit News',
                btnSubmitTxt: 'Update'
            },
            closeModal: {
                actionName: 'closeModal',
                isAddFrom: false,
                title: '',
                btnSubmitTxt: ''
            }
        }
    };
</script>
