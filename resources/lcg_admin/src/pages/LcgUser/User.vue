<template>
  <div class="tables-basic">
    <h2 class="page-title">Quảng lý - <span class="fw-semi-bold">Người dùng</span></h2>
    <b-row>
      <b-col>
        <Widget
          title="<h5>Danh sách <span class='fw-semi-bold'>Người dùng</span></h5>" customHeader settings close>
          <div class="table-resposive">
            <table class="table">
              <thead>
                <tr>
                  <th><input type="checkbox" v-model="checkAllList"/></th>
                  <th class="hidden-sm-down">{{$options.txtMsg.thSttTitle}}</th>
                  <th>{{$options.txtMsg.thNameTitle}}</th>
                  <th>{{$options.txtMsg.thEmailTitle}}</th>
                  <th class="hidden-sm-down">{{$options.txtMsg.thDateTitle}}</th>
                  <th class="hidden-sm-down">{{$options.txtMsg.thActionTitle}}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in lists" :key="row.id">
                  <td><input type="checkbox" :value="row.id" :id="row.id" v-model="checked" /></td>
                  <td>{{row.id}}</td>
                  <td>
                    {{row.name}}
                  </td>
                  <td>
                    {{row.email}}
                  </td>
                  <td class="text-semi-muted">
                    {{row.created_at}}
                  </td>
                  <td class="width-150">
                    <button>Sửa</button>
                    <button>Xóa</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix">
            <div class="float-right">
              <b-button variant="default" class="mr-xs" size="sm">Send to...</b-button>
              <b-dropdown variant="inverse" class="mr-xs" size="sm" text="Clear" right>
                <b-dropdown-item>Clear</b-dropdown-item>
                <b-dropdown-item>Move ...</b-dropdown-item>
                <b-dropdown-item>Something else here</b-dropdown-item>
                <b-dropdown-divider />
                <b-dropdown-item>Separated link</b-dropdown-item>
              </b-dropdown>
            </div>
            <p>Basic table with styled content</p>
          </div>
        </Widget>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import Vue from 'vue';
import {mapGetters, mapActions} from 'vuex';
import Widget from '@/components/Widget/Widget';
import Sparklines from '../../components/Sparklines/Sparklines'

export default {
  name: 'User',
  beforeCreate() {
    this.$store.dispatch('user/getUsers',[]);
  },
  components: { Widget, Sparklines },
  data() {
    return {
      checked:[],
      checkedAll: false,
      checkboxes1: [false, false, false, false],
      checkboxes2: [false, false, false, false, false, false],
      checkboxes3: [false, false, false, false, false, false],
    };
  },
  computed: {
      ...mapGetters('user', ['lists']),
      checkAllList: {
        get () {
          return this.checkedAll;
        },
        set (value) {
          this.checked = []
          if (value && this.lists) {
            this.lists.forEach((user) => {
              this.checked.push(user.id)
            })
          }
          this.checkedAll = (this.checked.length === this.lists.length);
        }
      },
  },
  methods: {
    ...mapActions({
      userList: 'user/getUsers'
    }),
    parseDate(date) {
      const dateSet = date.toDateString().split(' ');
      return `${date.toLocaleString('en-us', { month: 'long' })} ${dateSet[2]}, ${dateSet[3]}`;
    },
    checkAll(ev, checkbox) {
      const checkboxArr = (new Array(this[checkbox].length)).fill(ev.target.checked);
      Vue.set(this, checkbox, checkboxArr);
    },
    changeCheck(ev, checkbox, id) {
      this[checkbox][id] = ev.target.checked;
      if (!ev.target.checked) {
        this[checkbox][0] = false;
      }
    },
    getRandomData() {
      const result = [];

      for (let i = 0; i <= 8; i += 1) {
        result.push(Math.floor(Math.random() * 20) + 1);
      }

      return [{data: result}];
    },
    getRandomColor() {
      const {primary, success, info, danger} = this.appConfig.colors;
      const colors = [info, primary, danger, success];
      return {colors: [colors[Math.floor(Math.random() * colors.length)]]}
    }
  },
  txtMsg: {
    formTitle : 'Người dùng',
    thSttTitle: 'Stt',
    thNameTitle: 'Tên',
    thEmailTitle: 'Email',
    thDateTitle: 'Ngày tháng',
    thActionTitle: 'Thao tác'
  }
};
</script>

<style src="./Basic.scss" lang="scss" scoped />
