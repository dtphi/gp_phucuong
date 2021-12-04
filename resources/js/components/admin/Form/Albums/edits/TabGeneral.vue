<template>
    <div class="tab-content">    
        <!-- Name -->
        <div class="form-group required">
            <label for="input-info-name" class="col-sm-2 control-label"
                >Tên Albums</label
            >
            <div class="col-sm-10">
                <validation-provider
                    name="info_name_albums"
                    rules="required|max:200"
                    v-slot="{ errors }"
                >
                    <input
                        v-model="groupData.albums_name"
                        type="text"
                        id="input-info-name"
                        class="form-control"
                        placeholder="Tên albums"
                    />

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <!-- List group_albums -->
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-info-giaohat"
                >Thuộc nhóm Albums</label
            >
            <div class="col-sm-10">
                <validation-provider
                    name="info_group_albums"
                    rules="max:50"
                    v-slot="{ errors }"
                >
                    <select
                        v-model="groupData.group_albums_id"
                        class="form-control"
                    >
                        <option
                            v-for="item in isGroupAlbums"
                            v-bind:value="item.id"
                            :key="item.id"
                        >
                            {{ item.group_name }}
                        </option>
                    </select>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <!-- Status -->
        <div class="form-group">
            <label for="input-info-status" class="col-sm-2 control-label"
                >Trạng thái</label
            >
            <div class="col-sm-10">
                <validation-provider
                    name="info_status"
                    rules="max:255"
                    v-slot="{ errors }"
                >
                    <select
                        v-model="groupData.status"
                        id="input-info-status"
                        class="form-control"
                    >
                        <option value="1" selected="selected">Xảy ra</option>
                        <option value="0">Ẩn</option>
                    </select>
                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>  
        <!-- SORT ORDER -->      
        <div class="form-group">
            <label class="col-sm-2 control-label"
                   for="input-info-sort-id">Thứ tự</label>
            <div class="col-sm-10">
                <validation-provider
                    name="sort_order"
                    rules="numeric|max:191"
                    v-slot="{ errors }">
                    <input type="text"
                           v-model="groupData.sort_id"
                           name="sort_order"
                           placeholder="Thứ tự hiển thị"
                           id="input-info-sort-id"
                           class="form-control"/>

                    <span class="cms-text-red">{{ errors[0] }}</span>
                </validation-provider>
            </div>
        </div>
        <!-- a block container is required -->
        <h5>Album Hình</h5>
        <div class="col-sm-12">
            <div class="docs-galley mb-3" style="position: relative;">
                <ul class="docs-pictures clearfix" id="images">
                    <li v-for="album in groupData.group_images" :key="album.id">
                        <img class="thumb" @click="_showSlide()"
                            :data-original="`http://localhost:8000/Image/NewPicture/${album.image}`" 
                            :src="`/Image/NewPicture/${album.image}`" alt="Picture 1"></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import { config } from "@app/common/config";
import {
    fn_get_tinymce_langs_url,
    fn_get_href_base_url
} from "@app/api/utils/fn-helper";
import { MODULE_MODULE_ALBUMS_ADD } from "store@admin/types/module-types";
import tinymce from "vue-tinymce-editor";
import 'viewerjs/dist/viewer.css';
import Viewer from 'viewerjs';

export default {
    name: "TabGeneralForm",
    components: {
        tinymce
    },
    props: {
        groupData: {
            type: Object
        },
        media: {
            type: Object
        }
    },
    computed: {
        ...mapState(MODULE_MODULE_ALBUMS_ADD, {
            isGroupAlbums: state => { 
              return state.list_group_albums;
            }
        }),
        _getImageAvatar() {
            if (this.groupData.image != "") {
                return fn_get_href_base_url(this.groupData.image);
            }
            return "/images/no-photo.jpg";
        }
    },
    data() {
        const _self = this;
        return {
            fn: null,
            mm: null,
            options: {
                language_url: fn_get_tinymce_langs_url("vi_VN"),
                height: "500",
                image_prepend_url: window.origin + "/",
                file_picker_callback: function(callback, value, meta) {
                    _self.media.options._selfCom = _self;
                    if (meta.filetype === "file") {
                        _self.fn = callback;
                        document.getElementById(
                            "media-file-manager-content"
                        ).style = "display:block";
                    }
                    if (meta.filetype === "image") {
                        _self.fn = callback;
                        document.getElementById(
                            "media-file-manager-content"
                        ).style = "display:block";
                    }
                    if (meta.filetype === "media") {
                        _self.fn = callback;
                        document.getElementById(
                            "media-file-manager-content"
                        ).style = "display:block";
                    }
                },
                referrer_policy: "strict-origin-when-cross-origin",
                toolbar2:
                    "undo redo | styleselect | fontsizeselect | fontselect | image ",
                font_formats:
                    "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats"
            },
            viewer: false
        };
    },
    watch: {
        groupData: {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                if (newValue && Object.keys(newValue).length) {
                    newValue.albums_name = newValue.albums_name === null ? "" : newValue.albums_name;						
                    return newValue;
                }
            }
        }
    },
    setting: {
        cf: config
    },
    methods: {
        _showSlide () {
            if (this.viewer) {
                return ;
            }
            new Viewer(document.getElementById('images'), {
                url: 'data-original'
            });
            this.viewer = true;
        }
    }
};
</script>

<style scoped>
    .docs-pictures {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .docs-pictures > li {
        border: 1px solid transparent;
        float: left;
        height: calc(100% / 6);
        margin: 0 -1px -1px 0;
        overflow: hidden;
        width: calc(100% / 6);
    }
    .docs-pictures > li > img {
        cursor: -webkit-zoom-in;
        cursor: zoom-in;
        width: 100%;
    }

</style>