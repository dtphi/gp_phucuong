<template>
    <ul class="breadcrumb">
        <li v-for="(item,index) in breadcrumbs"
            :class="{'active': !!item.linkPath}"
            :key="index">
            <font-awesome-icon v-if="!index" icon="home" size="xs"/>
            <a href="javascript:void(0);" @click="_redirectTo(index)">{{item.name}}</a>
        </li>
    </ul>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        name: 'Breadcrumb',
        data() {
            return {
                breadcrumbs: []
            };
        },
        mounted() {
            this._updateBreadcrumbs()
        },
        methods: {
            _updateBreadcrumbs() {
                this.breadcrumbs = this.$route.meta.breadcrumbs
            },
            _redirectTo(index) {
                if (this.breadcrumbs[index].linkPath) {
                    window.location = window.location.origin + '/admin' + this.breadcrumbs[index].linkPath
                }
            },
            _routeTo(index) {
                /*watch: {'$route' () {this._updateBreadcrumbs()}}*/
                if (this.breadcrumbs[index].linkName) {
                    this.$router.push(this.breadcrumbs[index].linkName)
                }
            }
        }
    };
</script>
