<template>
    <li @click="_selectRelatedInfo()">
        <a href="javascript:void(0);">{{information.name}}</a>
    </li>
</template>

<script>
    import {
        mapActions
    } from 'vuex';
    import {
        MODULE_INFO_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_SELECT_DROPDOWN_RELATED_INFO
    } from 'store@admin/types/action-types';

    export default {
        name: 'DropdownToInfoRelatedAutocomplete',
        props: {
            information: {
                default: {}
            }
        },
        methods: {
        	...mapActions(MODULE_INFO_ADD, [
        			ACTION_SELECT_DROPDOWN_RELATED_INFO
        	]),
            _selectRelatedInfo() {
                this.[ACTION_SELECT_DROPDOWN_RELATED_INFO](this.information);
            }
        },
        setting: {
        }
    };
</script>
