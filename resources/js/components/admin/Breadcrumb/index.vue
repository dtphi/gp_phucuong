<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item" v-for="(item,index) in breadcrumbs"
                            :class="{'active': !!item.linkPath}"
                            :key="index">
                            <a href="javascript:void(0);" @click="_redirectTo(index)">{{item.name}}</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
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
