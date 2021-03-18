<template>
    <div class="modal-header">
        <label class="col-sm-2">Parent name:</label>

        <div class="col-sm-10">
            <p>{{parentInfo.newsgroupname}}</p>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters
    } from 'vuex';
    import {
        MODULE_NEWS_GROUP_MODAL
    } from 'store@admin/types/module-types';

    export default {
        name: 'TheGroupInfo',
        props: {
            parentInfo: {
                type: Object,
                default: {},
                validator: function (value) {
                    var id = (value.id && Number.isInteger(value.id));
                    var name = (value.newsgroupname && value.newsgroupname.length);
                    if (value.father_id !== -1) return (id && name);

                    return true;
                }
            }
        },
        ...mapGetters(MODULE_NEWS_GROUP_MODAL, [
            'isOpen'
        ])
    };
</script>
