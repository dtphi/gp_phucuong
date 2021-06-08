<template>
     <tr>
        <td>
            <select 
                v-model="banner.top">
                <option v-for="item in $options.setting.positionTop" 
                    :value="item" 
                    :key="item" 
                    :selected="banner.top == item">{{item}}</option>
            </select>
        </td>
        <td>
            <select 
                v-model="banner.left">
                <option v-for="item in $options.setting.positionLeft" 
                    :value="item" 
                    :key="item" 
                    :selected="banner.left == item">{{item}}</option>
            </select>
        </td>
        <td>
            <validation-provider
                :name="`item_color`"
                rules="max:100"
                v-slot="{ errors }">
                <input 
                    v-model="banner.color" type="text" class="form-control" />

                <span class="cms-text-red">{{ errors[0] }}</span>
            </validation-provider>
        </td>
        <td>
            <select 
                v-model="banner.font_weight">
                <option v-for="item in $options.setting.fontWeight" 
                    :value="item" 
                    :key="item" 
                    :selected="banner.font_weight == item">{{item}}</option>
            </select>
        </td>
        <td>
            <select 
                v-model="banner.font_size">
                <option v-for="item in $options.setting.fontSize" 
                    :value="item" 
                    :key="item" 
                    :selected="banner.font_size == item">{{item}}</option>
                <option v-for="item in $options.setting.fontSizeText" 
                    :value="item" 
                    :key="item" 
                    :selected="banner.font_size == item">{{item}}</option>
            </select>
        </td>
        <td><span>@screen-media:{{banner.media}}</span>
        </td>
    </tr>   
</template>

<script>

    export default {
        name: 'TheItemBannerFormat',
        props: {
            banner: {
                default: {}
            }
        },
        setting: {
            arrMedia: 4,
            positionTop: 50,
            positionLeft: 50,
            fontWeight: [100,200,300,400,500,600,700,800,900,'bold', 'inherit', 'lighter', 'normal'],
            fontSize: 50,
            fontSizeText: ['large', 'medium', 'small', 'xx-large', 'xx-small', 'xxx-large', '-webkit-xxx-large']
        }
    };
</script>
