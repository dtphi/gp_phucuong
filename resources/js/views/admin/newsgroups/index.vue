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
                  News Groups List
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
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import { mapActions } from 'vuex';
    import Breadcrumb from 'com@admin/Breadcrumb';
    import TreeItem from './components/TheTreeItem';

    export default {
        name: 'Login',
        components: {Breadcrumb, TreeItem},
        data() {
            return {
              treeData:{
                name: "Danh Mục :",
                children: [
                  { name: "Ơn gọi linh mục" },
                  { name: "Dòng tu" },
                  {
                    name: "Giáo phận",
                    children: [
                      {
                        name: "Nhà thờ chánh tòa"
                      },
                      { name: "Năm thánh" },
                      { name: "Giám mục" },
                      {
                        name: "Giáo hạc - Giáo sứ",
                        children: [
                          { name: "Hạt Bến Cát" }, { name: "Hạt Bình Long" }, { name: "Hạt Củ Chi" }
                        ]
                      }
                    ]
                  }
                ]
              },
            };
        },
        computed: {
          lists () {
            return this.treeData
          }
        },
        methods: {
        }
    };
</script>