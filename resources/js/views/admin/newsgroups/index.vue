<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <Breadcrumb />

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <div class="card user-lst">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-user mr-2"></i>
                  {{$options.setting.title}}
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="treeview-animated mx-4 my-4">
                  <ul class="treeview-animated-list">
                    <TreeItem
                        class="treeview-animated-items"
                        :item="lists" />
                  </ul>
                </div>
              </div>
            </div>
          </section>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <FormModal />

    <v-dialog />
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import TreeItem from './components/TheTreeItem';
    import FormModal from 'com@admin/Modal/NewsGroups/AddForm';
    import {
      MODULE_NEWS_GROUP,
    } from 'store@admin/types/module-types';
    import {
      ACTION_GET_NEWS_GROUP_LIST,
    } from 'store@admin/types/action-types';

    export default {
        name: 'NewsGroupsList',
        components: {Breadcrumb, TreeItem, FormModal},
        beforeCreate() {
          this.$store.dispatch(MODULE_NEWS_GROUP+'/'+ ACTION_GET_NEWS_GROUP_LIST);
        },
        data() {
            return {
            };
        },
        computed: {
          ...mapGetters(MODULE_NEWS_GROUP, ['newsGroups', 'loading']),
          lists () {
            return this.newsGroups
          }
        },
        methods: {
        },
        setting: {
          title: 'News Groups List'
        }
    };
</script>