<template>
    <div class="tab-content">
        <div class="form-group required">
            <label class="col-sm-2 control-label"
                   for="input-code-name">Mã Module Code</label>
            <div class="col-sm-10">
                <input disabled
                       v-model="moduleData.code"
                       type="text"
                       placeholder="Mã Module Code" id="input-code-name"
                       class="form-control">
            </div>
        </div>

        <item-sach-noi></item-sach-noi>
    </div>
</template>

<script>
    import ItemSachNoi from './Infos/ItemSachNoi';

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
    };
</script>
