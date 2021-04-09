<template>
    <div class="tab-content">

            <div class="form-group required">
                <label 
                    for="input-info-name" 
                    class="col-sm-2 control-label">{{$options.setting.name_txt}}</label>
                <div class="col-sm-10">
                    <validation-provider 
                        name="news_name" 
                        rules="required|max:191" 
                        v-slot="{ errors }">
                        <input 
                            v-model="generalData.newsname"
                            type="text" 
                            name="input-info-name" 
                            class="form-control"
                            :placeholder="$options.setting.name_txt">

                        <span class="cms-text-red">{{ errors[0] }}</span>
                    </validation-provider>
                </div>
            </div>

            <div class="form-group">
                <label 
                    for="input-info-description" 
                    class="col-sm-2 control-label">{{$options.setting.info_description_txt}}</label>
                <div class="col-sm-10">
                    <tinymce 
                        id="input-info-description" 
                        :other_options="options"
                        v-model="generalData.description"></tinymce>
                </div>
            </div>

            <div class="form-group required">
                <label 
                    for="input-info-meta-title"
                    class="col-sm-2 control-label">{{$options.setting.info_meta_title_txt}}</label>
                <div class="col-sm-10">
                    <validation-provider 
                        name="info_meta_title" 
                        rules="required|max:191" v-slot="{ errors }">
                        <input 
                            v-model="generalData.meta_title" 
                            class="form-control"
                            :placeholder="$options.setting.info_meta_title_txt">

                        <span class="cms-text-red">{{ errors[0] }}</span>
                    </validation-provider>
                </div>
            </div>

            <div class="form-group">
                <label 
                    for="input-info-key-word" 
                    class="col-sm-2 control-label">{{$options.setting.info_key_word_txt}}</label>
                <div class="col-sm-10">
                    <validation-provider 
                        name="info_key_word" 
                        rules="required|max:191" 
                        v-slot="{ errors }">
                        <input 
                            v-model="generalData.key_word" 
                            class="form-control"
                            :placeholder="$options.setting.info_key_word_txt">

                        <span class="cms-text-red">{{ errors[0] }}</span>
                    </validation-provider>
                </div>
            </div>

    </div>
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
            'generalData': {
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
            name_txt: 'Tên',
            info_description_txt: 'Mô tả',
            info_key_word_txt: 'Từ khóa',
            info_meta_title_txt: 'Meta title',
        }
    };
</script>
