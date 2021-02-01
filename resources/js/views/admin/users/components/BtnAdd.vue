<template>
    <button type="button" class="btn btn-default mb-3" @click="showModal('add')">
    	<font-awesome-icon icon="plus"  size="xs" />
    </button>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'ButtonAdd',
        data() {
            return {
            };
        },
        methods: {
        	...mapActions('user/modal', ['showModal']),
        }
    };
</script>