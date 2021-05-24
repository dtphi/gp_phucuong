<template>
    <div class="tab-content">
        <item-image></item-image>
    </div>
</template>

<script>
    import ItemImage from './Infos/ItemImage';

    export default {
        name: 'TabSlideImage',
        components: {
            ItemImage
        },
        props: {
            moduleData: {
                type: Object
            }
        },
    };
</script>
