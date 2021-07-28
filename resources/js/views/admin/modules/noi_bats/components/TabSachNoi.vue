<template>
    <div class="tab-content">
        <div class="form-group required">
            <label class="col-sm-2 control-label"
                   for="input-code-name">Mã Module Code</label>
            <div class="col-sm-10">
                <input disabled
                       :value="texts[moduleData.code].text"
                       type="text"
                       placeholder="Mã Module Code" id="input-code-name"
                       class="form-control">
            </div>
        </div>

        <item-sach-noi :module-code="moduleData.code"></item-sach-noi>
    </div>
</template>

<script>
    import {
        mapGetters,
    } from 'vuex';
    import ItemSachNoi from './Infos/ItemSachNoi';
    import {
        MODULE_MODULE_APP
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheTabDataSachNoi',
        components: {
            ItemSachNoi
        },
        props: {
            moduleData: {
                type: Object
            }
        },
        computed: {
            ...mapGetters(MODULE_MODULE_APP, ['texts']),
        }
    };
</script>
