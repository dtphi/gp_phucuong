<template>
  <div class="tables-basic">
    <h2 class="page-title">Quảng lý - <span class="fw-semi-bold">{{$options.txtMsg.formTitle}}</span></h2>
    <b-row>
      <b-col>
        <Widget>
          <ul>
            <TreeItem
              class="item"
              :item="treeData"
              @make-folder="makeFolder"
              @add-item="addItem"
            ></TreeItem>
          </ul>
        </Widget>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import Vue from 'vue';
import {mapGetters, mapActions} from 'vuex';
import Widget from '@/components/Widget/Widget';
import TreeItem from './TreeItem';

export default {
  name: 'NewsGroup',
  beforeCreate() {
    this.$store.dispatch('user/getUsers',[]);
  },
  components: { Widget, TreeItem },
  data() {
    return {
      treeData:{
        name: "News Group Tree",
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
      }
    };
  },
  computed: {
      ...mapGetters('user', ['lists'])
  },
  methods: {
    ...mapActions({
      userList: 'user/getUsers'
    }),
    makeFolder: function(item) {
      Vue.set(item, "children", []);
      this.addItem(item);
    },
    addItem: function(item) {
      item.children.push({
        name: "Thêm danh mục mới"
      });
    }
  },
  txtMsg: {
    formTitle : 'NewsGroup',
    thSttTitle: 'Stt',
    thNameTitle: 'Tên',
    thEmailTitle: 'Email',
    thDateTitle: 'Ngày tháng',
    thActionTitle: 'Thao tác'
  }
};
</script>

<style src="./NewsGroup.scss" lang="scss" scoped />
