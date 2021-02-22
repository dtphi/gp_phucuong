<template>
    <li>
        <news-group-item
            :is-item-root="isRoot"
            :group="item" 
            :is-folder="isFolder"></news-group-item>

        <ul class="nested" v-if="isFolder">
            <news-group-tree-item
                class="treeview-animated-items"
                v-for="(child, index) in item.children"
                :key="index"
                :item="child"></news-group-tree-item>
        </ul>
    </li>
</template>

<script>
    import NewsGroupItem from './Item';

    export default {
        name: 'NewsGroupTreeItem',
        components: {
            'NewsGroupTreeItem': this,
            'NewsGroupItem': NewsGroupItem
        },
        props: {
            isRoot: 0,
            item: [Object, Array]
        },
        data: function () {
            return {
                selectedGroup: {}
            };
        },
        computed: {
            isFolder() {
                return this.item.children && Object.keys(this.item.children).length;
            }
        }
    };
</script>
