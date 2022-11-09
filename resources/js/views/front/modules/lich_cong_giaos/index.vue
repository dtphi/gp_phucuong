<template>
  <div id="lich-cong-giao-module" class="calendar mt-4">
    <div class="hcalendarbox" id="hcalendarbox">
      <div class="pleft"></div>
      <div class="pright">
        <table class="table table-bordered" v-if="dayselect != null">
          <tr class="todaybox" :class="dayselect.n==='7'?'text-danger':''">
            <td colspan="7" >
              <p class="thutoday" :class="dayselect.n==='7'?'text-danger':''">
                {{ dayselect.l }}
              </p>
              <p class="daytoday" :class="dayselect.n==='7'?'text-danger':''">
                {{ dayselect.day }}
              </p>
              <p class="monthyeartoday">
                Tháng {{ dayselect.month }} năm {{ dayselect.year }} (năm {{dayselect.namthanh}})
              </p>

              <div v-for="itemle in dayselect.le">
                <a v-if="itemle.code==='HANHCACTHANH'" class="todayle todayHanhCacThanh" :href="gethref(itemle)">{{ itemle.name }}</a>
                <p v-else class="todayle">{{ itemle.name }}</p>

                <p class="todayphucam">
                  <span :class="itemphucam.match(regex)!=null?'pam':''"  @click="showPAM(itemphucam)" v-for="itemphucam in PhucAmHover(itemle.phucam).split('|')" v-html="itemphucam"></span>
                  
                </p>
              </div>

              <p class="todayal">
                Âm Lịch: Ngày {{ dayselect.amlich.day }} tháng {{ dayselect.amlich.month }} năm {{ dayselect.amlich.year
                }}
              </p>
            </td>
          </tr>
          <tr class="chonlich">
            <td @click="prevYear()"> &#60;&#60; </td>
            <td @click="prevMonth()">
              &#60; </td>
            <td colspan="3">
              {{ thismonth }}/{{ thisyear }}
            </td>
            <td @click="nextMonth()"> &#62; </td>
            <td @click="nextYear()"> &#62;&#62; </td>
          </tr>
          <tr class="lichThu">
            <td v-for="item in lstThu" :class="item==='CN'?'table-warning':''">
              {{ item }}
            </td>
          </tr>
          <tr v-for="lstitem in lstCalTab">
            <td class="ngaylich" :class="dayselect===item?'selectedDay indexNgay' + item.n:'indexNgay' + item.n" v-for="item in lstitem" @click="selectDay(item)">
              <span class="dl" :class="item.isToday ? 'istoday' : item.month != thismonth ? 'othermonth' : ''">{{
                  item.day
                    < 10 ? '0' + parseInt(item.day) : item.day
              }}</span>
                  <span class="al">
                    {{ item.amlich.day < 10 ? '0' + parseInt(item.amlich.day) : item.amlich.day }} </span>
            </td>
          </tr>
        </table>
      </div>
    </div>
      <b-modal ref="PhucAmModal" hide-footer :title="phucamtite">
        <div class="PhucAm">
          <span class="PhucAmLine" v-for="item in phucam" :sach="item.ten" :chuong="item.chuong" :cau="item.cau"
            v-html="'<i>[' + item.cau + ']</i>' + item.noidung">
          </span>
        </div>
      </b-modal>
    

  </div>
</template>

<script>
var lstThu = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'
export default {
  name: 'ModuleLichCongGiao',
  components: {},
  data() {
    return {
      fullPage: true,
      lstCal: [],
      lstCalTab: [],
      thisday: 0,
      thismonth: 0,
      thisyear: 0,
      dayselect: null,
      dayselecttmp: null,
      lstThu: lstThu,
      phucam:[],
      regex: /[1-9a-zA-ZĐđ]+ \d+,?(\d+)?.?(\d+)?(\w+)?-?(\d+)?,?(\d+)?.?(\d+)?(\w+)?-?(\d+),?(\d+)?.?(\d+)(\w)?(-\d+)?/g,
      phucamtite:'',
      hrefHanhCacThanh:'',
    }
  },
  methods: {
    showPAM(code) {
      //console.log(code)
      var self = this
      var url = window.location.origin + '/api/app/calendar/getpam';
      var data = code
      // $.ajaxSetup({
      //       headers: {
      //          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //       }
      //    });
      $.ajax({
        type: 'GET',
        url: url,
        data: {data:data},
        success: function (json) {
          self.phucam = json;
          self.phucamtite = code;
          self.$refs['PhucAmModal'].show()
        }
      })
    },
    
    LoadCal(month, year) {
      var self = this
      var url = window.location.origin + '/api/app/calendar/getlist' + '?month=' + month + '&year=' + year + '&firebasephone=1';
      $.getJSON(url, function (json) {
        self.lstCal = json
        self.CalToTable()
        if (self.dayselect == null) { self.dayselect = self.lstCal.filter(item => item.isToday)[0] }
        $('#hcalendarbox').fadeIn()
      });
    },
    CalToTable() {
      var self = this
      var sl = self.lstCal.length / 7
      self.lstCalTab = [];
      for (var i = 0; i <= sl; i++) {
        self.lstCalTab.push(self.lstCal.slice(i * 7, i * 7 + 7));
      }
    },
    prevYear(){
      var self = this
      self.thisyear-=1
      self.LoadCal(self.thismonth, self.thisyear)
    },
    prevMonth() {
      var self = this
      if (self.thismonth > 1) {
        self.thismonth -= 1;
      }
      else {
        self.thismonth = 12;
        self.thisyear -= 1;
      }
      self.LoadCal(self.thismonth, self.thisyear)
    },
    nextMonth() {
      var self = this
      if (self.thismonth < 12) {
        self.thismonth += 1;
      }
      else {
        self.thismonth = 1;
        self.thisyear += 1;
      }
      self.LoadCal(self.thismonth, self.thisyear)
    },
    nextYear(){
      var self = this
      self.thisyear+=1
      self.LoadCal(self.thismonth, self.thisyear)
    },
    selectDay(item) {
      var self = this
      self.dayselect = item;
    },
    gethref(item){
      //console.log(item)
      const regex=/[\/\#\?\&\\\%]/g;
      return fn_get_href_base_url(`/hanh-cac-thanh/chi-tiet/${fn_change_to_slug(item.name).replace(regex,'')}-${item.idngayle}`)
    },
    PhucAmHover(str) {
      //console.log(str)
      const regex = this.regex;
      if (str == undefined || str == null || str == '') return '';
      var res = str.replace(regex, "|$&|")
      // var res = str.replace(regex, "<span id='phucamspan' class='pam'>$&</span>")
      // //document.getElementById ("phucamspan").addEventListener ("click", showPAM(`$&`), false)
      //console.log(res.replace(/#/gi, '').replaceAll('<p>','').replaceAll('</p>',''))
      return res.replace(/#/gi, '').replaceAll('<p>','').replaceAll('</p>','');
    },
  },
  mounted() {
    var now = new Date();
    var self = this;
    self.thisday = now.getDate();
    self.thismonth = now.getMonth() + 1;
    self.thisyear = now.getFullYear();
    self.LoadCal(self.thismonth, self.thisyear);

    

  },
  setting: {
    panel_title: 'Module Danh Mục Icon',
    frm_title: 'Thêm danh mục Icon',
    btn_save_txt: 'Lưu',
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>