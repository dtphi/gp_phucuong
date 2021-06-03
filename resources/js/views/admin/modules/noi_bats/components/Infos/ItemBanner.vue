<template>
     <tr>
        <td class="text-left">
            <div class="file animated fadeIn" style="height: 61px">
                <div class="file-preview">
                    <img :src="_getImgUrl()" class="thumb"/>
                </div>
            </div>
        </td>
        <td>
            <validation-provider
                :name="`item_title_${banner.id}`"
                rules="max:200"
                v-slot="{ errors }">
                    <input 
                        v-model="banner.title" type="text" class="form-control" />

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </td>
        <td>
            <validation-provider
                :name="`item_url_full_${banner.id}`"
                rules="required|url|max:500"
                v-slot="{ errors }">
                    <input 
                        v-model="banner.url_full" type="text" class="form-control" />

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </td>
        <td>
            <validation-provider
                :name="`item_sort_order${banner.id}`"
                rules="numeric|max:5"
                v-slot="{ errors }">
                <input 
                    v-model="banner.width" type="text" class="form-control" />

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </td>
        <td>
            <validation-provider
                :name="`item_sort_order${banner.id}`"
                rules="numeric|max:5"
                v-slot="{ errors }">
                <input 
                    v-model="banner.height" type="text" class="form-control" />

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </td>
        <td>
            <select 
                v-model="banner.status">
                <option value="1" :selected="(banner.status == 1)?'selected':''">Xảy ra</option>
                <option value="0" :selected="(banner.status == 0)?'selected':''">Ẩn</option>
            </select>
        </td>
        <td>
            <select 
                v-model="banner.open">
                <option value="0" :selected="banner.open == 0">_blank</option>
                <option value="1" :selected="banner.open == 1">_self</option>
            </select>
        </td>
        <td>
            <button 
                type="button" 
                @click="_removeBanner"
                data-toggle="tooltip"
                class="btn btn-default cms-btn">
                    <font-awesome-layers size="1x" style="background:MistyRose">
                        <font-awesome-icon icon="circle" style="color:Tomato"/>
                        <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-4"/>
                    </font-awesome-layers>
            </button>
        </td>
    </tr>   
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_MODULE_NOI_BAT
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheItemBanner',
        props: {
            banner: {
                default: {}
            }
        },
        methods: {
            ...mapActions(MODULE_MODULE_NOI_BAT, [
                'module_noi_bat_banners_action_remove'
            ]),
            _getImgUrl() {
                return '/Image/NewPicture/'+this.banner.image;
            },
            _removeBanner() {
                this.module_noi_bat_banners_action_remove(this.banner);
            }
        },
        setting: {
            image_title: 'Banner',
            image_url_title: 'Url hình'
        }
    };
</script>
