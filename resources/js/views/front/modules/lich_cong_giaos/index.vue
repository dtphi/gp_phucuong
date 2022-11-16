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
              <p class="BonMangChiuChuc" @click="showLmDetail()"
                v-if="dayselect!=null && (dayselect.ngaychiuchuc.length == undefined || dayselect.bonmang.length == undefined)">
                Ngày bổn mạng & ngày chịu chức
              </p>

              <p class="todayal">
                Âm Lịch: Ngày {{ dayselect.amlich.day }} tháng {{ dayselect.amlich.month }} năm {{ dayselect.amlich.year
                }}
              </p>
            </td>
          </tr>
          <tr class="chonlich">
            <td class="hand" @click="prevYear()"> &#60;&#60; </td>
            <td class="hand" @click="prevMonth()">
              &#60; </td>
            <td colspan="3">
              {{ thismonth }}/{{ thisyear }}
            </td>
            <td class="hand" @click="nextMonth()"> &#62; </td>
            <td class="hand" @click="nextYear()"> &#62;&#62; </td>
          </tr>
          <tr class="lichThu">
            <td v-for="item in lstThu" :class="item==='CN'?'table-warning':''">
              {{ item }}
            </td>
          </tr>
          <tr v-for="lstitem in lstCalTab">
            <td class="ngaylich hand" :class="dayselect===item?'selectedDay indexNgay' + item.n:'indexNgay' + item.n" v-for="item in lstitem" @click="selectDay(item)">
              <span class="dl" :class="item.isToday ? 'istoday' : item.month != thismonth ? 'othermonth' : ''">{{
                  item.day
                    < 10 ? '0' + parseInt(item.day) : item.day
              }}</span>
                  <span class="al">
                    {{ item.amlich.day < 10 ? '0' + parseInt(item.amlich.day) : item.amlich.day }}{{item.amlich.day==1?'/'+item.amlich.month:''}} </span>
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

      <b-modal ref="LinhMucDetailModal" hide-footer title="Ngày bổn mạng và ngày chịu chức">
        <div class="dayDetailLm" v-if="dayselect != null">
            <div class="chiuChucBox" v-if="dayselect.ngaychiuchuc.length == undefined">
              <p class="titlelmdetail">Ngày chịu chức</p>
              <div class="itemLm" v-for="item in dayselect.ngaychiuchuc">
                <p class="lmName">
                  Cha:
                  <span class="lmTenThanh">{{item.holyname}}</span>
                  <span class="lmTen">{{item.fullname}}</span>
                  <span class="lmAge">
                    {{item.rip==null ? getAge(item.birthday) : '(Đã mất)'}}
                  </span>

                </p>
                <p class="lmInfo">
                  ngày:
                  <span class="lmInfoDate">
                    {{changeDate(item.ordinationdate)}},
                  </span>
                  chịu chức:
                  <span class="lmInfoChuc">
                    {{strSpace(item.position)}},
                  </span>
                  tại:
                  <span class="lmInfoPlace">
                    {{strSpace(item.ordinationplace)}},
                  </span>
                  do cha: 
                  <span class="lmInfoUser">
                    {{strSpace(item.ordinationuser)}}
                    thụ phong
                  </span>
                </p>

              </div>
            </div>
            <div class="bonMangBox" v-if="dayselect.bonmang.length == undefined">
              <p class="titlelmdetail">Ngày bổn mạng</p>
              <div class="itemLm" v-for="item in dayselect.bonmang">
                <p class="itemBonMang">
                  <span class="lmTenThanh">{{item.holyname}}</span>
                  <span class="lmTen">{{item.fullname}}</span>
                </p>

              </div>
            </div>
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
        var self = this
        var url = window.location.origin + '/api/app/calendar/getpam';
        var data = code
        $.ajax({
          type: 'GET',
          url: url,
          data: {
            data: data
          },
          success: function(json) {
            self.phucam = json;
            self.phucamtite = code;
            self.$refs['PhucAmModal'].show()
          }
        })
      },
      prevYear() {
        var self = this
        self.thisyear -= 1
        self.LoadCal(self.thismonth, self.thisyear)
      },
      nextYear() {
        var self = this
        self.thisyear += 1
        self.LoadCal(self.thismonth, self.thisyear)
      },
      prevMonth() {
        var self = this
        if (self.thismonth > 1) {
          self.thismonth -= 1;
        } else {
          self.thismonth = 12;
          self.thisyear -= 1;
        }
        self.LoadCal(self.thismonth, self.thisyear)
      },
      LoadCal(month, year) {
        var self = this
        var url = window.location.origin + '/api/app/calendar/getlist' + '?month=' + month + '&year=' + year + '&firebasephone=1';
        $.getJSON(url, function(json) {
          self.lstCal = json
          self.CalToTable()
          if (self.dayselect == null) {
            self.dayselect = self.lstCal.filter(item => item.isToday)[0]
          }
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
      prevMonth() {
        var self = this
        if (self.thismonth > 1) {
          self.thismonth -= 1;
        } else {
          self.thismonth = 12;
          self.thisyear -= 1;
        }
        self.LoadCal(self.thismonth, self.thisyear)
      },
      nextMonth() {
        var self = this
        if (self.thismonth < 12) {
          self.thismonth += 1;
        } else {
          self.thismonth = 1;
          self.thisyear += 1;
        }
        self.LoadCal(self.thismonth, self.thisyear)
      },
      selectDay(item) {
        var self = this
        self.dayselect = item;
      },
      gethref(item) {
        const regex=/[\/\#\?\&\\\%]/g;
        return fn_get_href_base_url(`/hanh-cac-thanh/chi-tiet/${fn_change_to_slug(item.name).replace(regex,'')}-${item.idngayle}`)
      },
      PhucAmHover(str) {
        const regex = this.regex;
        if (str == undefined || str == null || str == '') return '';
        var res = str.replace(regex, "|$&|")
        return res.replace(/#/gi, '').replaceAll('<p>', '').replaceAll('</p>', '');
      },
      changeDate(date) {
        var sp = date.split('-')
        if (sp.length < 3) return date;
        var day = sp[2]
        var month = sp[1]
        var year = sp[0]
        var yearnow = new Date().getFullYear()
        var minusyear = yearnow - year
        var str = day + "/" + month + "/" + year
        if (minusyear > 0) {
          str += " (" + minusyear + " năm)";
        }
        return str;
      },
      getAge(date) {
        var sp = date.split('-')
        if (sp.length < 3) return date;
        var day = sp[2]
        var month = sp[1]
        var year = sp[0]
        var yearnow = new Date().getFullYear()
        var minusyear = yearnow - year
        var str = ""
        if (minusyear > 0) {
          str += " (" + minusyear + " tuổi)";
        }
        return str;
      },
      showLmDetail() {
        var self = this
        self.$refs['LinhMucDetailModal'].show()
      },
      strSpace(str){
        if(str==null || str == "") return '___________'
        return str;
      }
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