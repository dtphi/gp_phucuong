<template>
    <div class="tab-content">
        <div class="form-group">
            <div class="col-sm-12">
                <info-list :lists="groupData.bang_caps"></info-list>
            </div>
        </div>
    </div>
</template>

<script>
    import InfoList from './BangCaps/InfoList';

    export default {
        name: 'TabBangCapForm',
        components: {
            InfoList
        },
        props: {
            groupData: {
                type: Object
            }
        },
        data() {
            return {
                bang_caps: []
            }
        },
    };
</script>
