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

        <info-to-category-autocomplete-edit></info-to-category-autocomplete-edit>
    </div>
</template>

<script>
    import InfoToCategoryAutocompleteEdit from './Category/InfoToCategoryAutocompleteEdit';

    export default {
        name: 'TheTabData',
        components: {
            InfoToCategoryAutocompleteEdit
        },
        props: {
            moduleData: {
                type: Object
            }
        },
    };
</script>
