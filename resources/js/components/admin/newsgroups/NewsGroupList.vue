<template>
    <div class="sales-cont" :style="'min-height: ' + height">
        <div class="div-content bg-white p-4 shadow">
            <b-row class="row frm-search" align-h="between">
                <b-col cols="12" sm="5" lg="3" class="mb-2">
                    <b-link :to="{ name: 'admin.representatives.create' }" role="button" class="btn blue-btn-custom btn-block">
                        <i class="fas fa-plus mr-2"></i> 新規登録
                    </b-link>
                </b-col>
                <b-col cols="12" sm="7" lg="4">
                    <b-input-group class="mb-3">
                        <b-input-group-prepend>
                            <b-input-group-text>
                                <i class="fas fa-search"></i>
                            </b-input-group-text>
                        </b-input-group-prepend>

                        <b-form-input type="text" v-model="search" maxlength="20" placeholder="検索する" @keypress="onSearchPress"></b-form-input>

                        <b-input-group-append>
                            <b-button class="btn blue-btn-custom custom-btn" :disabled="isLoading" @click="onSearch">検索</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
            </b-row>
            <b-row>
              <ul>
                <TreeItem
                  class="item"
                  :item="lists"
                  @make-folder="makeFolder"
                  @add-item="addItem"
                ></TreeItem>
              </ul>
            </b-row>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import * as API from '../../../stores/API'
    import TreeItem from './TreeItem'

    export default {
        name: 'NewsGroupList',
        components: {TreeItem},
        data() {
            return {
                lists:{
                  name: "News Group Tree",
                  children: []
                },
                search: '',
                height: '0'
            };
        },
        mounted() {
            this.height = this.calculateHeight();

            this.getList();
        },
        methods: {
            getList() {
              const self = this;
              axios.get(API.API_ADMIN_NEWSGROUP_LIST, []).then(response => {
                var status = response.status;

                if (status == 200) {
                  self.lists.children = response.data.data.newsGroupTrees;
                }
              })
            },
            onSearch() {
                this.$refs.tableRepresentatives.setFilter(this.search);
            },
            onSearchPress(event) {
                if (event.keyCode === 13 && !this.isLoading) {
                    event.preventDefault();
                    this.$refs.tableRepresentatives.setFilter(this.search);
                }
            },
            makeFolder: function(item) {
              Vue.set(item, "children", []);
              this.addItem(item);
            },
            addItem: function(item) {console.log(item.children)
              item.children[Date.now()]={
                name: "Thêm danh mục mới"
              };
            }
        }
    };
</script>

<style src="./NewsGroup.scss" lang="scss" scoped />
