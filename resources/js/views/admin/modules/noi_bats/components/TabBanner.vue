<template>
    <div class="tab-content">
        <item-banner></item-banner>
    </div>
</template>

<script>
    import ItemBanner from './Infos/ItemBanner';

    export default {
        name: 'TheTabDataItemBanner',
        components: {
            ItemBanner
        },
        props: {
            moduleData: {
                type: Object
            }
        },
    };
</script>
