<template>
  <div id="lich-cong-giao-module" class="calendar mt-4">

    <!-- <h4 class="title"><span>Lịch</span></h4> -->
    <!-- <b-calendar class="w-100" locale="vi-VN"></b-calendar> -->

    <div class="hcalendarbox" id="hcalendarbox">
      <div class="pleft"></div>
      <div class="pright">
        <table class="table table-bordered">
          <tr class="todaybox">
            <td colspan="7" v-if="dayselect!=null">
              <p class="thutoday">
                {{dayselect.l}}
              </p>
              <p class="daytoday">
                {{dayselect.day}}
              </p>
              <p class="monthyeartoday">
                Tháng {{dayselect.month}} năm {{dayselect.year}}
              </p>

              <p class="todayle" v-for="itemle in dayselect.le">
                {{itemle.name}}
              </p>

              <p class="todayal">
                Âm Lịch: Ngày {{dayselect.amlich.day}} tháng {{dayselect.amlich.month}} năm {{dayselect.amlich.year}}
              </p>
            </td>
          </tr>
          <tr class="chonlich">
            <td @click="prevMonth()">
              &#60; </td>
            <td colspan="5">
              Tháng {{thismonth}} năm {{thisyear}}
            </td>
            <td @click="nextMonth()"> &#62; </td>
          </tr>
          <tr class="lichThu">
            <td v-for="item in lstThu">
              {{item}}
            </td>
          </tr>
          <tr v-for="lstitem in lstCalTab">
            <td class="ngaylich" :class="'indexNgay'+item.n" v-for="item in lstitem" @click="selectDay(item)">
              <span class="dl" :class="item.isToday ? 'istoday' : item.month!=thismonth ? 'othermonth' : '' ">{{item.day
              < 10 ? '0' + parseInt(item.day) : item.day}}</span>
                  <span class="al">
                    {{item.amlich.day < 10 ? '0' + parseInt(item.amlich.day) : item.amlich.day}} </span>
            </td>
          </tr>
        </table>
      </div>
    </div>

  </div>
</template>

<script>
var lstThu = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
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
    }
  },
  methods: {
    LoadCal(month, year) {
      var self = this
      var url = window.location.origin + '/api/app/calendar/getlist' + '?month=' + month + '&year=' + year;
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
    selectDay(item) {
      var self = this
      self.dayselect = item;
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