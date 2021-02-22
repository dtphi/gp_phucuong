<template>
    <li>
        <the-item
            :is-item-root="isRoot"
            :group="item"
            :is-folder="isFolder"></the-item>

        <ul class="nested" v-if="isFolder">
            <the-tree-item
                class="treeview-animated-items"
                v-for="(child, index) in item.children"
                :key="index"
                :item="child"></the-tree-item>
        </ul>
    </li>
</template>

<script>
    import TheItem from './TheItem';

    export default {
        name: 'TheTreeItem',
        components: {
            'TheTreeItem': this,
            'TheItem': TheItem
        },
        props: {
            isRoot: 0,
            item: [Object, Array]
        },
        data: function () {
            return {};
        },
        computed: {
            isFolder() {
                return this.item.children && Object.keys(this.item.children).length;
            }
        }
    };
</script>
